<?php
namespace App\Shell;

use App\Classes\ImageFetcher;
use Cake\Console\Shell;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * AddAdminUser shell command.
 */
class ListBuildersconSpeakersShell extends Shell
{

    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $url = "https://api.builderscon.io/v2/session/list?conference_id=557400a7-1e3d-43ba-a4d6-ab3e8f87e696&lang=ja";
        $sessions = json_decode(file_get_contents($url));

        /** @var \App\Model\Entity\Conference $conference */
        $conference = TableRegistry::get('Conferences')->find()->where(['slug' => 'builderscon-tokyo-2017'])->first();

        $imageFetcher = new ImageFetcher($conference);

        /** @var \App\Model\Table\UsersTable $usersTable */
        $usersTable = TableRegistry::get('Users');

        $nicknames = [];
        $idx = 1;
        foreach ($sessions as $session){
            $speakerObject = $session->speaker;
            if ($speakerObject->nickname == 'lestrrat'){
                continue;
            }
            if (in_array($speakerObject->nickname, $nicknames)){
                echo("Duplicate speaker!!: ".$speakerObject->nickname."\n");
            } else {
                $nicknames[] = $speakerObject->nickname;
            }

            $hash = sha1(Configure::read('App.hashSalts.user').$speakerObject->id);

            // Create UserEntity
            $user = $usersTable->find()->where(['hash' => $hash])->first();
            if (! $user){
                $user = $usersTable->newEntity();
            }

            // Download avatar file
            $ticketNo = sprintf("スピーカー / #%d", $idx);
            $filenameBase = $imageFetcher->safeString($ticketNo);
            $image = file_get_contents($speakerObject->avatar_url);
            file_put_contents($fullPath = $imageFetcher->pathAvatar.$filenameBase, $image);
            $ext = $imageFetcher->supposeFileType($fullPath);
            rename($fullPath, $fullPath.$ext);

            // Patch entity
            $user->mail = 'builderscon@example.com';
            $user->password = 'beaconkun';
            $user->conference_id = $conference->id;
            $user->hash = $hash;
            $user->vote_page_view = 0;
            $user->avatar_icon_filename = $filenameBase.$ext;
            $user->name = $speakerObject->nickname;
            $user->ticket_type = 'スピーカー';
            $user->ticket_no = $ticketNo;
            $user->ticket_json = json_encode($speakerObject);

            // Validate
            $errors = $user->getErrors();
            if ($errors){
                debug($errors);
            }

            // Save speaker
            $user = $usersTable->save($user);

            // Fetch QR
            $imageFetcher->fetchQr($user);

            $idx++;
        }
    }
}
