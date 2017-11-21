<?php
use Migrations\AbstractMigration;

class AddSessionFeedback extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('conferences', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('vote_close_at', 'datetime', ['default' => null, 'null' => true, 'after' => 'vote_url_base']);
        $table->update();

        $table = $this->table('session_feedbacks', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('user_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('session_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('is_reviewed', 'boolean', ['default' => false, 'null' => false,]);
        $table->addColumn('review_memo', 'text', ['default' => null, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG, 'null' => true]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('session_feedback_answers', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('session_feedback_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('session_feedback_question_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('answer', 'text', ['default' => null, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG, 'null' => true]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('session_feedback_questions', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('conference_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('question_no', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('lang', 'string', ['default' => null, 'limit' => 255, 'null' => true]);
        $table->addColumn('question', 'string', ['default' => null, 'limit' => 255, 'null' => true]);
        $table->addColumn('question_type', 'string', ['default' => null, 'limit' => 255, 'null' => true]);
        $table->addColumn('option_json', 'string', ['default' => null, 'limit' => 255, 'null' => true]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();
    }
}
