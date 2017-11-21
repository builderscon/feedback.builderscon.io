<?php
namespace App\Classes\SessionImporter;

use App\Classes\ImageFetcher;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Classes\GoogleSpreadSheets;


class IosdcSessionImporter extends SessionImporter
{
    public function import()
    {
        $cmd = ROOT.'/bin/cake dump_google_spreadsheet 1uTGBsotmKCeRTWR7HfNxNoWtDR4IpRagD7lRQfrZ8Vg merged';
        $lines = null;
        exec($cmd, $lines);
        $output = implode("", $lines);

        $records = json_decode($output, true);
        $errors = [];
        foreach ($records as $sessionJsonArray){
            if (! $sessionJsonArray['開始']){
                continue;
            }
            $result = $this->importSession($sessionJsonArray);
            if (! $result['session']){
                $errors[] = print_r($result['errors'], true);
            }
        }

        return $errors;
    }


    public function importSession($sessionJsonArray)
    {
        /** @var \App\Model\Table\SessionsTable $sessionsTable */
        $sessionsTable = TableRegistry::get('Sessions');
        /** @var \App\Model\Entity\Speaker $speaker */
        $speaker = $this->importSpeaker($sessionJsonArray);
        /** @var \App\Model\Entity\Track $track */
        $track = $this->importTrack($sessionJsonArray);

        /** @var \App\Model\Entity\Session $sessionJsonArray */
        $session = $sessionsTable->find()->where(['source_identifier' => $sessionJsonArray['id']])->first();
        if (! $session){
            $session = $sessionsTable->newEntity();
        }

        // Patch object
        $session->source_identifier = $sessionJsonArray['id'];
        $session->conference_id = $this->conference->id;
        $session->track_id = $track->id;
        $session->start_at = strtotime($sessionJsonArray['開始']) + 60 * 60 * 9;
        $session->duration_min = $sessionJsonArray['採用時間'];
        $session->speaker_id = $speaker->id;
        $session->hash = sha1(Configure::read('App.hashSalts.session').$sessionJsonArray['id']);
        $session->title = $sessionJsonArray['トークタイトル'];
        $session->is_vote_target = ($sessionJsonArray['投票対象'] == '1');
        $session->is_feedback_target = ($sessionJsonArray['フィードバック対象'] == '1');

        // Vote group
        if ($session->duration_min == 5){
            // If LT, group is 3 or 4
            if (date('Ymd', $session->start_at) == '20170917'){
                $session->vote_group_id = 3;
            } else if (date('Ymd', $session->start_at) == '20170918'){
                $session->vote_group_id = 4;
            } else {
                die("Something wrong! session: ".$session->title." start_at:".date('Ymd', $session->start_at));
            }
        } else {
            // Regular talks are group 2
            $session->vote_group_id = 2;
            // Regular talks have description.
            $session->description = $sessionJsonArray['トーク概要'];
        }


        if (! ($errors = $session->getErrors())){
            $session = $sessionsTable->save($session);
        }

        return ['session' => $session, 'errors' => $errors];
    }

    public function importTrack($trackJsonArray)
    {
        /** @var \App\Model\Table\TracksTable $tracksTable */
        $tracksTable = TableRegistry::get('tracks');

        // Return if track already exists
        $trackName = 'Track '.$trackJsonArray['トラック'];
        if ($track = $tracksTable->find()->where(['name' => $trackName])->first()){
            return $track;
        }

        /** @var \App\Model\Entity\Track $track */
        $track = $tracksTable->newEntity();

        $track->conference_id = $this->conference->id;
        $track->name = $trackName;
        $track->slug = sprintf("track-%s", strtolower($trackJsonArray['トラック']));

        return $tracksTable->save($track);
    }

    public function importSpeaker($speakerJsonArray)
    {
        /** @var \App\Model\Table\SpeakersTable $speakerTable */
        $speakersTable = TableRegistry::get('Speakers');

        // Return if speaker already exists
        if ($speaker = $speakersTable->find()->where(['name' => $speakerJsonArray['プログラムへの表示名']])->first()){
            //return $speaker;
        } else {
            /** @var \App\Model\Entity\Speaker $speaker */
            $speaker = $speakersTable->newEntity();
        }


        $user = TableRegistry::get('Users')
            ->find()
            ->where(['originid' => $speakerJsonArray['id']])
            ->first();
        if ($user){
            $speaker->user_id = $user->id;
        }

        $speaker->name = $speakerJsonArray['プログラムへの表示名'];
        if (isset($speakerJsonArray['Twitterアカウント']) and $speakerJsonArray['Twitterアカウント']){
            $speaker->twitter = '@'.$speakerJsonArray['Twitterアカウント'];

            // Import avatar from twitter
            $if = new ImageFetcher($this->conference);
            $filename = $if->downloadTwitterAvatar($speaker->twitter, $if->pathSpeakerAvatar, $speaker->twitter);
            if ($filename){
                $url = sprintf('%sfiles/%s/avatar-speakers/%s', $this->conference->vote_url_base, $this->conference->slug, urlencode($filename));
                $speaker->avatar_url = $url;
            } else {
                $speaker->avatar_url = null;
            }
        }

        return $speakersTable->save($speaker);
    }
}

