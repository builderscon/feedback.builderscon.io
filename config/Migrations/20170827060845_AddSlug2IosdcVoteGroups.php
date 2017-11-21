<?php
use Migrations\AbstractMigration;

class AddSlug2IosdcVoteGroups extends AbstractMigration
{
    public function up()
    {
        $this->execute('update vote_groups set slug = "regular-sessions" where conference_id = 2 and name="レギュラーセッション";');
        $this->execute('update vote_groups set slug = "lt-0916", voting_cards = 15 where conference_id = 2 and name="LT 9/16（土）";');
        $this->execute('update vote_groups set slug = "lt-0917", voting_cards = 15 where conference_id = 2 and name="LT 9/17（日）";');
    }
}
