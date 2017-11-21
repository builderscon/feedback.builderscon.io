<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SessionFeedbacksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SessionFeedbacksTable Test Case
 */
class SessionFeedbacksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SessionFeedbacksTable
     */
    public $SessionFeedbacks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.session_feedbacks',
        'app.users',
        'app.conferences',
        'app.session_feedback_questions',
        'app.session_feedback_answers',
        'app.sessions',
        'app.tracks',
        'app.speakers',
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
        $config = TableRegistry::exists('SessionFeedbacks') ? [] : ['className' => SessionFeedbacksTable::class];
        $this->SessionFeedbacks = TableRegistry::get('SessionFeedbacks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SessionFeedbacks);

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
