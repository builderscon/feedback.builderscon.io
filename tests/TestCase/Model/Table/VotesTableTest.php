<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VotesTable Test Case
 */
class VotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VotesTable
     */
    public $Votes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.votes',
        'app.sessions',
        'app.conferences',
        'app.session_feedback_questions',
        'app.session_feedback_answers',
        'app.session_feedbacks',
        'app.users',
        'app.speakers',
        'app.tracks',
        'app.vote_groups'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Votes') ? [] : ['className' => VotesTable::class];
        $this->Votes = TableRegistry::get('Votes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Votes);

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
