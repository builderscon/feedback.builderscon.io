<?php
namespace App\Classes;

use App\Model\Entity\Conference;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Facebook\Facebook;
use ZipArchive;

class ImageFetcher
{
    /**
     * @var Conference $conference
     */
    public $conference;
    /**
     * @var string $pathBase
     */
    public $pathBase;
    /**
     * @var string $pathConference
     */
    public $pathConference;
    /**
     * @var string $pathAvatar
     */
    public $pathAvatar;
    /**
     * @var string $pathSpeakerAvatar
     */
    public $pathSpeakerAvatar;
    /**
     * @var string $pathQr
     */
    public $pathQr;
    /**
     * @var string $pathArchive
     */
    public $pathArchive;

    public $twitterConnection = null;
    public $facebookConnection = null;

    public function __construct(Conference $conference)
    {
        $this->conference = $conference;
        // Create work dirs
        if (! is_dir($this->pathBase = TMP.'files'.DS)){
            mkdir($this->pathBase);
        }
        if (! is_dir($this->pathConference = $this->pathBase.$this->conference->slug.DS)){
            mkdir($this->pathConference);
        }
        if (! is_dir($this->pathAvatar = $this->pathConference.'avatar'.DS)){
            mkdir($this->pathAvatar);
        }
        if (! is_dir($this->pathSpeakerAvatar = $this->pathConference.'avatar-speakers'.DS)){
            mkdir($this->pathSpeakerAvatar);
        }
        if (! is_dir($this->pathQr = $this->pathConference.'qr'.DS)){
            mkdir($this->pathQr);
        }
        if (! is_dir($this->pathArchive = $this->pathConference.'archive'.DS)){
            mkdir($this->pathArchive);
        }
    }

    public function createArchive()
    {
        // Create zip file
        $zipFile = $this->pathArchive.$this->conference->slug.date('Ymd-His').'.zip';

        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE){
            $zip->addFile($this->pathAvatar, 'avatar');
            $zip->addFile($this->pathQr, 'qr');
            /*
            $zip->addEmptyDir('qr');
            foreach ($files as $file){
                $zip->addFile($path_work.$file, 'qr/'.$file);
            }
            */
            $zip->close();
        }

        /*
        // Clean files up
        foreach ($files as $file){
            unlink($path_work.$file);
        }
        rmdir($path_work);

        // Send zip file as a response
        $this->autoRender = false;
        $this->response->file($zipFile, ['download' => true]);
        */
    }

    public function fetchAvatars()
    {
        // Check if are ticket numbers unique
        if (! $this->checkTicketNoIsUnique()){
            return false;
        }
        // Loop with users
        $users = TableRegistry::get('Users')
            ->find()
            ->where(['conference_id' => $this->conference->id])
            ->order(['Users.id'])
            ->contain(['Conferences']);
        /** @var \App\Model\Entity\User $user */
        foreach ($users as $user){
            if (! $user->avatar_icon_filename){
                $this->fetchAvatar($user);
            }
        }
    }

    /**
     * @param \App\Model\Entity\User $user
     */
    public function fetchAvatar($user)
    {
        if (! $user->sns_accounts){
            return;
        }
        $snsAccounts = json_decode($user->sns_accounts, true);
        if (isset($snsAccounts['twitter'])){
            if ($this->fetchTwitterAvatar($user)){
                return;
            }
        }
        if (isset($snsAccounts['github'])){
            if ($this->fetchGithubAvatar($user)){
                return;
            }
        }
        if (isset($snsAccounts['facebook'])){
            if ($this->fetchFacebookAvatar($user)){
                return;
            }
        }
    }

    public function checkTicketNoIsUnique(){
        /** @var \App\Model\Table\UsersTable $users */
        $users = TableRegistry::get('Users')
            ->find()
            ->where(['conference_id' => $this->conference->id])
            ->order(['Users.id'])
            ->contain(['Conferences']);
        $ticketNos = [];
        foreach ($users as $user){
            /** @var \App\Model\Entity\User $user */
            if (isset($ticketNos[$user->ticket_no])){
                return false;
            }
            $ticketNos[$user->ticket_no] = true;
        }
        return true;
    }

    public function flushAvatars()
    {
        $this->removeFiles($this->pathAvatar);
        TableRegistry::get('Users')->updateAll(['avatar_icon_filename' => null], ['conference_id' => $this->conference->id]);
    }

    /**
     * @param \App\Model\Entity\User $user
     */
    public function fetchTwitterAvatar($user)
    {
        $snsAccounts = json_decode($user->sns_accounts);
        if (! isset($snsAccounts->twitter)){
            return false;
        }
        $account = $snsAccounts->twitter;

        $savedFilename = $this->downloadTwitterAvatar($account, $this->pathAvatar, $user->ticket_no);

        $user->avatar_icon_filename = $savedFilename;
        TableRegistry::get('Users')->save($user);

        return true;
        // https://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png
        // http://pbs.twimg.com/profile_images/511145785652568064/yMT5EoXV_normal.jpeg
    }

    public function downloadTwitterAvatar($account, $destination, $filename)
    {
        if (is_null($this->twitterConnection)){
            $this->twitterConnection = new \TwistOAuth(
                Configure::read('App.twitter.consumerKey'),
                Configure::read('App.twitter.consumerSecret'),
                Configure::read('App.twitter.accessToken'),
                Configure::read('App.twitter.accessTokenSecret')
            );
        }

        try {
            $twitterUser = $this->twitterConnection->get('users/show', ['screen_name' => $account]);
        } catch (\TwistException $e){
            return false;
        }

        if (! isset($twitterUser->profile_image_url)){
            return false;
        }
        $avatarUrl = $twitterUser->profile_image_url;
        // Remove _normal from image url to get large image
        $avatarUrlLarge = str_replace('_normal.', '.', $avatarUrl);

        $image = @file_get_contents($avatarUrlLarge);
        if ($image === false){
            $image = file_get_contents($avatarUrl);
            if ($image === false){
                return false;
            }
        }

        $filename = $this->safeString($filename);
        file_put_contents($destination.$filename, $image);

        // Add extension
        $ext = null;
        $pi = pathinfo($avatarUrl);
        if (isset($pi['extension'])){
            $ext = '.'.$pi['extension'];
        } else {
            $ext = $this->supposeFileType($destination.$filename);
        }
        $ext = strtolower($ext);
        if ($ext){
            rename($destination.$filename, $destination.$filename.$ext);
        }

        // Crop if it's not square shape
        $fullPath = $destination.$filename.$ext;
        switch ($ext){
            case '.jpg':
            case '.jpeg':
                $image = imagecreatefromjpeg($fullPath);
                break;
            case '.png':
                $image = imagecreatefrompng($fullPath);
                break;
            default:
                return false;
        }
        $width = imagesx($image);
        $height = imagesy($image);
        if ($width !== $height){
            $square = ($width >= $height)? $height: $width;
            $srcX = intval(($width - $square) / 2);
            $srcY = intval(($height - $square) / 2);
            $imageSquare = imagecreatetruecolor($square, $square);
            imagecopy($imageSquare, $image, 0, 0, $srcX, $srcY, $square, $square);
            switch ($ext){
                case '.jpg':
                case '.jpeg':
                    imagejpeg($imageSquare, $fullPath, 100);
                    break;
                case '.png':
                    imagepng($imageSquare, $fullPath);
                    break;
            }
        }

        return $filename.$ext;
    }


    /**
     * @param \App\Model\Entity\User $user
     */
    public function fetchGithubAvatar($user)
    {
        $snsAccounts = json_decode($user->sns_accounts);
        if (! isset($snsAccounts->github)){
            return false;
        }
        $account = $snsAccounts->github;

        $url = sprintf("https://github.com/%s.png", $account);
        $image = @file_get_contents($url);
        if ($image === false){
            return false;
        }

        $filename = $this->safeString($user->ticket_no);
        $filenameFull = $this->pathAvatar.$filename;
        file_put_contents($filenameFull, $image);

        if ($ext = $this->supposeFileType($filenameFull)){
            rename($filenameFull, $filenameFull.$ext);
        } else {
            unlink($filenameFull);
        }

        $user->avatar_icon_filename = $filename.$ext;
        TableRegistry::get('Users')->save($user);

        return true;
    }

    public function supposeFileType($fullPath)
    {
        $type = exif_imagetype($fullPath);
        $ext = null;
        switch ($type){
            case IMAGETYPE_JPEG:
                $ext = '.jpg';
                break;
            case IMAGETYPE_PNG:
                $ext = '.png';
                break;
            default:
                return false;
        }
        return $ext;
    }

    /**
     * @param \App\Model\Entity\User $user
     */
    public function fetchFacebookAvatar($user)
    {
        $snsAccounts = json_decode($user->sns_accounts);
        if (! isset($snsAccounts->facebook)){
            return false;
        }
        $account = $snsAccounts->facebook;

        $url = sprintf("https://www.facebook.com/%s", $account);
        $contents = $this->httpGet($url);
        $matches = null;
        preg_match('@"fb://profile/([0-9]+)"@', $contents, $matches);
        if (count($matches) == 1){
            return false;
        }
        $userId = $matches[1];

        $imageUrl = sprintf("http://graph.facebook.com/%s/picture?width=3200&height=3200", $userId);
        $image = @file_get_contents($imageUrl);
        if ($image === false){
            return false;
        }

        $filename = $this->safeString($user->ticket_no).'.jpg';
        file_put_contents($this->pathAvatar.$filename, $image);

        $user->avatar_icon_filename = $filename;
        TableRegistry::get('Users')->save($user);

        return true;

        // fb://profile/100002069738453
        // "http://graph.facebook.com/asonas.P/picture?width=500&height=500"
    }

    public function fetchQrs()
    {
        // Create QR images
        $users = TableRegistry::get('Users')
            ->find()
            ->where(['conference_id' => $this->conference->id])
            ->order(['Users.id'])
            ->contain(['Conferences']);
        /** @var \App\Model\Entity\User $user */
        foreach ($users as $user){
            if (! $user->qr_filename){
                $this->fetchQr($user);
            }
        }
    }

    /**
     * @param \App\Model\Entity\User $user
     */
    public function fetchQr($user)
    {
        $voteUrl = sprintf("%svote/%s", $this->conference->vote_url_base, $user->hash);
        $qrUrl = 'http://chart.apis.google.com/chart?cht=qr&chs=482x482&chl='.$voteUrl;
        $image = file_get_contents($qrUrl);

        $filename = $this->safeString($user->ticket_no).'.png';
        file_put_contents($this->pathQr.$filename, $image);

        $user->qr_filename = $filename;
        TableRegistry::get('Users')->save($user);
    }

    public function flushQrs()
    {
        $this->removeFiles($this->pathQr);
        TableRegistry::get('Users')->updateAll(['qr_filename' => null], ['conference_id' => $this->conference->id]);
    }

    public function removeFiles($dir)
    {
        // Add DS to tail.
        if (substr($dir, -1, 1) !== DS){ $dir .= DS; }
        // Remove files.
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                    if ($file == '.' or $file == '..'){
                        continue;
                    }
                    unlink($dir.$file);
                }
            }
            closedir($dh);
        }
    }

    public function safeString($str)
    {
        $unsafeCharacters = ['\\', '/' ,':' ,'*' ,'?' ,'"' ,'<' ,'>' ,'|', ',', ' '];
        foreach ($unsafeCharacters as $c){
            $str = str_replace($c, '_', $str);
        }
        return $str;
    }

    public static function httpGet($url)
    {
        // CURL config
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set up heaaders
        $headers = array(
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Encoding:gzip ,deflate",
            "Accept-Language:ja-jp",
            "Connection:keep-alive",
            "User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.1 Safari/603.1.30"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Exec
        $html = curl_exec($ch);

        return $html;
    }
}
