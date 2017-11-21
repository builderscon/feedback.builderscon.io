<?php
namespace App\Test\TestCase\Classes\SessionImporter;

use App\Classes\SessionImporter\BuildersconSessionImporter;
use App\Model\Entity\Conference;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BuildersconSessionImporterTest extends TestCase
{
    public $fixtures = ['app.conferences', 'app.tracks', 'app.vote_groups', 'app.sessions', 'app.speakers'];

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {

    }

    public function testBuildersconSessionImporter()
    {
        $conference = TableRegistry::get("Conferences")->find()->where(['Conferences.id' => 1])->first();
        $importer = new BuildersconSessionImporter($conference);

        /** @var \App\Model\Table\SessionsTable $sessionsTable */
        $sessionsTable = TableRegistry::get('Sessions');
        $before = $sessionsTable->find()->count();
        $importer->import();
        self::assertNotEquals($sessionsTable->find()->count(), $before);
    }

    public function testImportSession()
    {
        $conference = TableRegistry::get("Conferences")->find()->where(['Conferences.id' => 1])->first();
        $importer = new BuildersconSessionImporter($conference);

        $json = json_encode([
            'id' => 'cd3aef93-dc85-453e-80a4-39b6b4983591',
            'conference_id' => '557400a7-1e3d-43ba-a4d6-ab3e8f87e696',
            'room_id' => '6d8135a9-afe6-42ad-b6bb-bf6bf1e3abea',
            'speaker_id' => '330b33cb-2df4-40c2-9807-6eaf068e5ec5',
            'session_type_id' => '55f78d4e-8f57-4c90-a9b5-979c3c09802d',
            'title' => 'Closing',
            'abstract' => 'Best Speaker Awards will be presented, and I will wrap things up',
            'memo' => 'test',
            'starts_on' => '2017-08-05T16:50:00+09:00',
            'duration' => 3600,
            'material_level' => 'beginner',
            'selection_result_sent' => true,
            'spoken_language' => 'ja',
            'slide_language' => 'ja',
            'photo_release' => 'allow',
            'recording_release' => 'allow',
            'materials_release' => 'allow',
            'has_interpretation' => false,
            'status' => 'accepted',
            'confirmed' => true,
            'room' => [
                'id' => '6d8135a9-afe6-42ad-b6bb-bf6bf1e3abea',
                'venue_id' => 'd7ed524b-1dba-4ca9-acab-e5512b09669e',
                'name' => '藤原洋記念ホール',
                'capacity' => 509,
            ],
            'speaker' => [
                'id' => '330b33cb-2df4-40c2-9807-6eaf068e5ec5',
                'avatar_url' => 'https://avatars.githubusercontent.com/u/49281?v=3',
                'lang' => 'ja',
                'nickname' => 'lestrrat',
                'is_admin' => true,
                'timezone' => 'Asia/Tokyo',
            ],
            'session_type' => [
                'id' => '55f78d4e-8f57-4c90-a9b5-979c3c09802d',
                'conference_id' => '557400a7-1e3d-43ba-a4d6-ab3e8f87e696',
                'name' => '60 min',
                'abstract' => '60分枠',
                'duration' => 3600,
                'submission_start' => '2017-05-08T04:00:00Z',
                'submission_end' => '2017-06-05T15:00:00Z',
                'is_default' => true,
                'is_accepting_submission' => false,
            ],
        ]);
        $sessionObject = json_decode($json);

        /** @var \App\Model\Table\SessionsTable $sessionsTable */
        $sessionsTable = TableRegistry::get('Sessions');

        // No records before import
        self::assertEquals(1, $sessionsTable->find()->where(['conference_id' => 1])->count());

        // Import a new record
        $result = $importer->importSession($sessionObject);
        self::assertEquals(2, $sessionsTable->find()->where(['conference_id' => 1])->count());
        self::assertEquals('Closing', $result['session']->title);

        // Import not vote target
        $sessionObject->is_vote_target = false;
        $result = $importer->importSession($sessionObject);
        self::assertEquals(1, $sessionsTable->find()->where(['conference_id' => 1])->count());

        // Import a new record
        $sessionObject->is_vote_target = true;
        $result = $importer->importSession($sessionObject);
        self::assertEquals(2, $sessionsTable->find()->where(['conference_id' => 1])->count());
        self::assertEquals('Closing', $result['session']->title);
    }

    public function testImportTrack()
    {
        $conference = TableRegistry::get("Conferences")->find()->where(['Conferences.id' => 1])->first();
        $importer = new BuildersconSessionImporter($conference);

        /*
         * room => object(stdClass) {
         *   id => '6d8135a9-afe6-42ad-b6bb-bf6bf1e3abea'
         *   venue_id => 'd7ed524b-1dba-4ca9-acab-e5512b09669e'
         *   name => '藤原洋記念ホール'
         *   capacity => (int) 509
         * }
         */

        $json = json_encode([
            'id' => '6d8135a9-afe6-42ad-b6bb-bf6bf1e3abea',
            'venue_id' => 'd7ed524b-1dba-4ca9-acab-e5512b09669e',
            'name' => '藤原洋記念ホール',
            'capacity' => 509,
        ]);
        $trackJsonObject = json_decode($json);

        /** @var \App\Model\Table\TracksTable $speakersTable */
        $tracksTable = TableRegistry::get('Tracks');

        // No records before import
        self::assertEquals(0, $tracksTable->find()->where(['slug' => $trackJsonObject->id])->count());

        // Import a new record
        $track = $importer->importTrack($trackJsonObject);
        self::assertEquals('藤原洋記念ホール', $track->name);
        self::assertEquals(1, $tracksTable->find()->where(['slug' => $trackJsonObject->id])->count());

        // 2nd run
        $track = $importer->importTrack($trackJsonObject);
        self::assertEquals('藤原洋記念ホール', $track->name);
        self::assertEquals(1, $tracksTable->find()->where(['slug' => $trackJsonObject->id])->count());
    }

    public function testImportSpeaker()
    {
        $conference = TableRegistry::get("Conferences")->find()->where(['Conferences.id' => 1])->first();
        $importer = new BuildersconSessionImporter($conference);

        /*
         * speaker => object(stdClass) {
         *   id => '330b33cb-2df4-40c2-9807-6eaf068e5ec5'
         *   avatar_url => 'https://avatars.githubusercontent.com/u/49281?v=3'
         *   lang => 'ja'
         *   nickname => 'lestrrat'
         *   is_admin => true
         *   timezone => 'Asia/Tokyo'
         * }
         */

        /** @var \App\Model\Table\SpeakersTable $speakersTable */
        $speakersTable = TableRegistry::get('Speakers');

        $json = json_encode([
            'id' => '330b33cb-2df4-40c2-9807-6eaf068e5ec5',
            'avatar_url' => 'https://avatars.githubusercontent.com/u/49281?v=3',
            'lang' => 'ja',
            'nickname' => 'lestrrat',
            'is_admin' => true,
            'timezone' => 'Asia/Tokyo',
        ]);
        $speakerJsonObject = json_decode($json);

        // No records before import
        self::assertEquals(0, $speakersTable->find()->where(['name' => 'lestrrat'])->count());

        // Import a new record
        $speaker = $importer->importSpeaker($speakerJsonObject);
        self::assertEquals('lestrrat', $speaker->name);
        self::assertEquals(1, $speakersTable->find()->where(['name' => 'lestrrat'])->count());

        // 2nd run
        $speaker = $importer->importSpeaker($speakerJsonObject);
        self::assertEquals('lestrrat', $speaker->name);
        self::assertEquals(1, $speakersTable->find()->where(['name' => 'lestrrat'])->count());
    }
}
