<?php
namespace App\Test\TestCase\Controller;

use App\Controller\VoteController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class VoteControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'app.votes',
        'app.sessions',
        'app.conferences',
        'app.users',
        'app.vote_groups',
        'app.speakers'
    ];

    public function setUp()
    {
        parent::setUp();

        $this->user = TableRegistry::get('Users')->find()->where(['Users.id' => 1])->first();
        $this->session = TableRegistry::get('Sessions')->find()->where(['Sessions.id' => 1])->first();
    }

    public function tearDown()
    {

    }

    public function testSessionList()
    {
    }

    public function testVote()
    {
        $url = sprintf('/vote/%s/post/%s', $this->user->hash, $this->session->hash);
        $this->get($url);

        $this->assertResponseOk();
        $resposne = json_decode($this->_response->body());
        self::assertNotEquals(null, $resposne);
        self::assertEquals('success', $this->result);
        self::assertEquals($this->user->hash, $resposne->user->hash);
        self::assertEquals($this->session->hash, $resposne->session->hash);
        self::assertTrue($this->session->voted);
        self::assertEquals(1, $response->voted);
        self::assertEquals(0, $response->votingCards);
    }
}
