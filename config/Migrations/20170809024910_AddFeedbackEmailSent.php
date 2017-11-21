<?php
use Migrations\AbstractMigration;

class AddFeedbackEmailSent extends AbstractMigration
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
        $table = $this->table('users', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('feedback_email_sent', 'boolean', ['default' => false, 'null' => true, 'after' => 'ticket_json']);
        $table->update();
    }
}
