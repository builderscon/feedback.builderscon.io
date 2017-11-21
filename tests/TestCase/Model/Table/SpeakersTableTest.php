<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpeakersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpeakersTable Test Case
 */
class SpeakersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SpeakersTable
     */
    public $Speakers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.speakers',
        'app.users',
        'app.conferences',
        'app.session_feedback_questions',
        'app.session_feedback_answers',
        'app.session_feedbacks',
        'app.sessions',
        'app.tracks',
        'app.vote_groups',
        'app.votes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Speakers') ? [] : ['className' => SpeakersTable::class];
        $this->Speakers = TableRegistry::get('Speakers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Speakers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
