<?php
use Migrations\AbstractMigration;

class AddUserIdToSpeakers extends AbstractMigration
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
        $table = $this->table('speakers', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('user_id', 'integer', ['default' => null, 'null' => true, 'after' => 'id']);
        $table->update();

        $table = $this->table('users', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('originid', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'id']);
        $table->update();
    }
}
