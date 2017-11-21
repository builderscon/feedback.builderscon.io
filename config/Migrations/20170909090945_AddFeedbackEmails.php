<?php
use Migrations\AbstractMigration;

class AddFeedbackEmails extends AbstractMigration
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
        $table->addColumn('feedback_mail_body', 'text', ['default' => null, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG, 'null' => true, 'after' => 'class_name']);
        $table->addColumn('feedback_mail_from', 'text', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'feedback_mail_body']);
        $table->addColumn('feedback_mail_from_name', 'text', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'feedback_mail_from']);
        $table->addColumn('feedback_mail_subject', 'text', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'feedback_mail_from_name']);
        $table->addColumn('feedback_report_mail_body', 'text', ['default' => null, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG, 'null' => true, 'after' => 'feedback_mail_subject']);
        $table->addColumn('feedback_report_mail_from', 'text', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'feedback_report_mail_body']);
        $table->addColumn('feedback_report_mail_from_name', 'text', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'feedback_report_mail_from']);
        $table->addColumn('feedback_report_mail_subject', 'text', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'feedback_report_mail_from_name']);
        $table->update();
    }
}
