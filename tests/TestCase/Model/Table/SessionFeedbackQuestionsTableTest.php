<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SessionFeedbackQuestionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SessionFeedbackQuestionsTable Test Case
 */
class SessionFeedbackQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SessionFeedbackQuestionsTable
     */
    public $SessionFeedbackQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.session_feedback_questions',
        'app.conferences',
        'app.sessions',
        'app.tracks',
        'app.speakers',
        'app.users',
        'app.session_feedbacks',
        'app.session_feedback_answers',
        'app.votes',
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
        $config = TableRegistry::exists('SessionFeedbackQuestions') ? [] : ['className' => SessionFeedbackQuestionsTable::class];
        $this->SessionFeedbackQuestions = TableRegistry::get('SessionFeedbackQuestions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SessionFeedbackQuestions);

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
