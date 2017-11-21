<?php
use Migrations\AbstractMigration;

class AddSessionLength extends AbstractMigration
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
        $table->addColumn('duration_min', 'integer', ['default' => null, 'null' => true, 'after' => 'start_at']);
        $table->update();
    }
}
