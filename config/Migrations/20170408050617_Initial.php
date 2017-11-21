<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
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
        $table->addColumn('name', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('slug', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('vote_url_base', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('class_name', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('tracks', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('conference_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('display_order', 'integer', ['default' => null, 'null' => true,]);
        $table->addColumn('name', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('slug', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('speakers', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('name', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('vote_groups', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('conference_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('name', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('voting_cards', 'integer', ['default' => 1, 'null' => false,]);
        $table->addColumn('voting_close_at', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('sessions', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('source_identifier', 'string', ['default' => null, 'limit' => 255, 'null' => true,]);
        $table->addColumn('conference_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('track_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('start_at', 'datetime', ['default' => null, 'null' => true,]);
        $table->addColumn('speaker_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('vote_group_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('number_of_votes', 'integer', ['default' => 0, 'null' => false,]);
        $table->addColumn('hash', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('title', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('users', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('mail', 'string', ['default' => null, 'limit' => 255, 'null' => false]);
        $table->addColumn('password', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('conference_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('hash', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('vote_page_view', 'integer', ['default' => 0, 'null' => false,]);
        $table->addColumn('avatar_icon_filename', 'string', ['default' => null, 'limit' => 255, 'null' => true,]);
        $table->addColumn('qr_filename', 'string', ['default' => null, 'limit' => 255, 'null' => true,]);
        $table->addColumn('name', 'string', ['default' => null, 'limit' => 255, 'null' => true,]);
        $table->addColumn('ticket_type', 'text', ['default' => null, 'null' => true,]);
        $table->addColumn('ticket_no', 'text', ['default' => null, 'null' => false,]);
        $table->addColumn('sns_accounts', 'text', ['default' => null, 'null' => true,]);
        $table->addColumn('ticket_json', 'text', ['default' => null, 'null' => true,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('votes', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('session_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('user_id', 'integer', ['default' => null, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();

        $table = $this->table('admin_users', ['collation' => 'utf8mb4_unicode_ci']);
        $table->addColumn('username', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('password', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('role', 'string', ['default' => null, 'limit' => 255, 'null' => false,]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => false,]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => false,]);
        $table->create();
    }
}
