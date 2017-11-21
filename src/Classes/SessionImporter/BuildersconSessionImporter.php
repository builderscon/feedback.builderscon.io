<?php
namespace App\Classes\SessionImporter;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class BuildersconSessionImporter extends SessionImporter
{
    public function import()
    {
        $url = "https://api.builderscon.io/v2/session/list?conference_id=557400a7-1e3d-43ba-a4d6-ab3e8f87e696&lang=ja";
        $sessions = json_decode(file_get_contents($url));

        $errors = [];
        foreach ($sessions as $sessionJsonObject){
            $result = $this->importSession($sessionJsonObject);
            if (! $result['session']){
                $errors[] = print_r($result['errors'], true);
            }
        }

        return $errors;
    }

    public function importSession($sessionJsonObject)
    {
        /** @var \App\Model\Table\SessionsTable $sessionsTable */
        $sessionsTable = TableRegistry::get('Sessions');
        /** @var \App\Model\Entity\Speaker $speaker */
        $speaker = $this->importSpeaker($sessionJsonObject->speaker);
        /** @var \App\Model\Entity\Track $track */
        $track = $this->importTrack($sessionJsonObject->room);

        /** @var \App\Model\Entity\Session $sessionJsonObject */
        $session = $sessionsTable->find()->where(['source_identifier' => $sessionJsonObject->id])->first();
        if (! $session){
            $session = $sessionsTable->newEntity();
        }

        // Delete session if it's not vote target
        //if (isset($sessionJsonObject->is_vote_target) and (! $sessionJsonObject->is_vote_target)){
        //    $sessionsTable->delete($session);
        //    return ['session' => null, 'errors' => __('Not vote target.')];
        //}
        // Patch object
        $session->source_identifier = $sessionJsonObject->id;
        $session->conference_id = $this->conference->id;
        $session->track_id = $track->id;
        $session->start_at = strtotime($sessionJsonObject->starts_on) + 9 * 60 * 60;
        $session->duration_min = $sessionJsonObject->duration / 60;
        $session->speaker_id = $speaker->id;
        $session->vote_group_id = 1;
        $session->hash = sha1(Configure::read('App.hashSalts.session').$sessionJsonObject->id);
        $session->title = $sessionJsonObject->title;

        if (! ($errors = $session->getErrors())){
            $session = $sessionsTable->save($session);
        }

        return ['session' => $session, 'errors' => $errors];
    }

    public function importTrack($trackJsonObject)
    {
        /** @var \App\Model\Table\TracksTable $tracksTable */
        $tracksTable = TableRegistry::get('tracks');

        // Return if track already exists
        if ($track = $tracksTable->find()->where(['slug' => $trackJsonObject->id])->first()){
            return $track;
        }

        /** @var \App\Model\Entity\Track $track */
        $track = $tracksTable->newEntity();

        $track->conference_id = $this->conference->id;
        $track->name = $trackJsonObject->name;
        $track->slug = $trackJsonObject->id;

        return $tracksTable->save($track);
    }

    public function importSpeaker($speakerJsonObject)
    {
        /** @var \App\Model\Table\SpeakersTable $speakerTable */
        $speakersTable = TableRegistry::get('Speakers');

        // Return if speaker already exists
        if ($speaker = $speakersTable->find()->where(['name' => $speakerJsonObject->nickname])->first()){
            return $speaker;
        }

        /** @var \App\Model\Entity\Speaker $speaker */
        $speaker = $speakersTable->newEntity();

        $user = TableRegistry::get('Users')
            ->find()
            ->where(['originid' => $speakerJsonObject->id])
            ->first();
        if ($user){
            $speaker->user_id = $user->id;
        }

        $speaker->name = $speakerJsonObject->nickname;

        return $speakersTable->save($speaker);
    }
}

/*
object(stdClass) {
        id => 'cd3aef93-dc85-453e-80a4-39b6b4983591'
        conference_id => '557400a7-1e3d-43ba-a4d6-ab3e8f87e696'
        room_id => '6d8135a9-afe6-42ad-b6bb-bf6bf1e3abea'
        speaker_id => '330b33cb-2df4-40c2-9807-6eaf068e5ec5'
        session_type_id => '55f78d4e-8f57-4c90-a9b5-979c3c09802d'
        title => 'Closing'
        abstract => 'Best Speaker Awards will be presented, and I will wrap things up'
        memo => 'test'
        starts_on => '2017-08-05T16:50:00+09:00'
        duration => (int) 3600
        material_level => 'beginner'
        selection_result_sent => true
        spoken_language => 'ja'
        slide_language => 'ja'
        photo_release => 'allow'
        recording_release => 'allow'
        materials_release => 'allow'
        has_interpretation => false
        status => 'accepted'
        confirmed => true
        room => object(stdClass) {
                id => '6d8135a9-afe6-42ad-b6bb-bf6bf1e3abea'
                venue_id => 'd7ed524b-1dba-4ca9-acab-e5512b09669e'
                name => '藤原洋記念ホール'
                capacity => (int) 509
        }
        speaker => object(stdClass) {
                id => '330b33cb-2df4-40c2-9807-6eaf068e5ec5'
                avatar_url => 'https://avatars.githubusercontent.com/u/49281?v=3'
                lang => 'ja'
                nickname => 'lestrrat'
                is_admin => true
                timezone => 'Asia/Tokyo'
        }
        session_type => object(stdClass) {
                id => '55f78d4e-8f57-4c90-a9b5-979c3c09802d'
                conference_id => '557400a7-1e3d-43ba-a4d6-ab3e8f87e696'
                name => '60 min'
                abstract => '60分枠'
                duration => (int) 3600
                submission_start => '2017-05-08T04:00:00Z'
                submission_end => '2017-06-05T15:00:00Z'
                is_default => true
                is_accepting_submission => false
        }
}
*/
