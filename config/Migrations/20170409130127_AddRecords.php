<?php
use Migrations\AbstractMigration;

class AddRecords extends AbstractMigration
{
    public function up()
    {
        $this->insert('admin_users', [
            ['id' => 1, 'username' => 'tom', 'password' => '$2y$10$eGfJVulf2Ijkh0DJ4x2Cu.fw4Aga7PA4qLBPIdKNkZzEp3iQCVSMy', 'role' => 'admin', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 2, 'username' => 'builderscon', 'password' => '$2y$10$Q9RLwyYXT9w6YtXRdy9jKuanXJK25qIMMtqFedRLxFpR8jOGyoqsW', 'role' => 'admin', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
        ]);
        $this->insert('conferences', [
            ['id' => 1, 'name' => 'builderscon tokyo 2017', 'slug' => 'builderscon-tokyo-2017', 'vote_url_base' => 'http://vote.2017.tokyo.builderscon.io/', 'class_name' => 'Builderscon', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 2, 'name' => 'iOSDC Japan 2017', 'slug' => 'iosdc-japan-2017', 'vote_url_base' => 'http://vote.local/', 'class_name' => 'Iosdc', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
        ]);
        /*
        $this->insert('speakers', [
            ['id' => 1, 'name' => 'lestrrat', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 2, 'name' => 'uzulla', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
        ]);
        */
        $this->insert('vote_groups', [
            ['id' => 1, 'conference_id' => 1, 'name' => 'レギュラーセッション', 'voting_cards' => 3, 'voting_close_at' => '2017-08-05 16:30:00', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 2, 'conference_id' => 2, 'name' => 'レギュラーセッション', 'voting_cards' => 3, 'voting_close_at' => '2017-09-17 18:30:00', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 3, 'conference_id' => 2, 'name' => 'LT 9/16（土）', 'voting_cards' => 15, 'voting_close_at' => '2017-09-16 18:30:00', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 4, 'conference_id' => 2, 'name' => 'LT 9/17（日）', 'voting_cards' => 15, 'voting_close_at' => '2017-09-17 18:30:00', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
        ]);
        /*
        $this->insert('sessions', [
            ['id' => 1, 'conference_id' => 1, 'start_at' => '2017-09-01 10:00', 'speaker_id' => 1, 'vote_group_id' => 1, 'hash' => '7310e75df332eaa3dfc1431067e33255', 'name' => 'おまえらのBBQは間違っている', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 2, 'conference_id' => 1, 'start_at' => '2017-09-01 11:00', 'speaker_id' => 2, 'vote_group_id' => 1, 'hash' => '5ff90447ed219f62413acb4a1e217745', 'name' => 'php.iniの話', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 3, 'conference_id' => 1, 'start_at' => '2017-09-01 12:00', 'speaker_id' => 2, 'vote_group_id' => 1, 'hash' => 'fc8f1a64f4582cd099cb1a07824193ca', 'name' => '初心者むけhttpoxyとか脆弱性とかの話 at #PHPBLT 5', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 4, 'conference_id' => 1, 'start_at' => '2017-09-01 13:00', 'speaker_id' => 2, 'vote_group_id' => 2, 'hash' => 'b7b3e3cde89c67d07f4be6426b14f789', 'name' => 'Perlに比べてPHPが不便（主観です） ああ…だから僕は…', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
            ['id' => 5, 'conference_id' => 1, 'start_at' => '2017-09-01 14:00', 'speaker_id' => 1, 'vote_group_id' => 2, 'hash' => 'd97a2d36fa47f685aa54121fd65cbfca', 'name' => 'Coding in the context era', 'created' => '2017-04-09 0:00:00', 'modified' => '2017-04-09 0:00:00'],
        ]);
        */
    }
}
