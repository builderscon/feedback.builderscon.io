<?php
use Migrations\AbstractMigration;

class AddVoteTarget extends AbstractMigration
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
        $table = $this->table('sessions', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('is_vote_target', 'boolean', ['default' => false, 'null' => false, 'after' => 'title']);
        $table->addColumn('is_feedback_target', 'boolean', ['default' => false, 'null' => false, 'after' => 'is_vote_target']);
        $table->update();
    }
}
