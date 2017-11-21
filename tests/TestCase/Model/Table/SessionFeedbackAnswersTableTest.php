<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SessionFeedbackAnswersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SessionFeedbackAnswersTable Test Case
 */
class SessionFeedbackAnswersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SessionFeedbackAnswersTable
     */
    public $SessionFeedbackAnswers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.session_feedback_answers',
        'app.session_feedbacks',
        'app.users',
        'app.conferences',
        'app.session_feedback_questions',
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
        $config = TableRegistry::exists('SessionFeedbackAnswers') ? [] : ['className' => SessionFeedbackAnswersTable::class];
        $this->SessionFeedbackAnswers = TableRegistry::get('SessionFeedbackAnswers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SessionFeedbackAnswers);

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
