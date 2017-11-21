<?php
use Migrations\AbstractMigration;

class AddSlug2VoteGroup extends AbstractMigration
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
        $table = $this->table('vote_groups', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('slug', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'name']);
        $table->update();
    }
}
