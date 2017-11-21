<?php
use Migrations\AbstractMigration;

class AddDescriptionToSessions extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('sessions', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('description', 'text', ['default' => null, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG, 'null' => true, 'after' => 'title']);
        $table->update();
    }
}
