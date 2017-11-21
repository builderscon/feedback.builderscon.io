<?php
namespace App\Test\Fixture\ImageFetcher;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'mail' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'conference_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'hash' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ticket_no' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sns_accounts' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'ticket_json' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'mail' => 'foo@example.com',
            'password' => 'Lorem ipsum dolor sit amet',
            'conference_id' => 1,
            'hash' => 'd294be9cdbe1125ffc44b27626391425',
            'ticket_no' => '#1',
            'sns_accounts' => '{}',
            'ticket_json' => '{}',
            'created' => '2017-06-11 14:51:29',
            'modified' => '2017-06-11 14:51:29'
        ],
        [
            'id' => 2,
            'mail' => 'foo@example.com',
            'password' => 'Lorem ipsum dolor sit amet',
            'conference_id' => 1,
            'hash' => 'd294be9cdbe1125ffc44b27626391425',
            'ticket_no' => '#2',
            'sns_accounts' => '{"twitter":"tomzoh","github":"hasegawa-tomoki","facebook":"hasegawa.tomoki"}',
            'ticket_json' => '{}',
            'created' => '2017-06-11 14:51:29',
            'modified' => '2017-06-11 14:51:29'
        ],
        [
            'id' => 3,
            'mail' => 'foo@example.com',
            'password' => 'Lorem ipsum dolor sit amet',
            'conference_id' => 1,
            'hash' => 'd294be9cdbe1125ffc44b27626391425',
            'ticket_no' => '#3',
            'sns_accounts' => '{"twitter":"ezQDaqOqKfbP3Kn","github":"hasegawa-tomoki","facebook":"hasegawa.tomoki"}',
            'ticket_json' => '{}',
            'created' => '2017-06-11 14:51:29',
            'modified' => '2017-06-11 14:51:29'
        ],
        [
            'id' => 4,
            'mail' => 'foo@example.com',
            'password' => 'Lorem ipsum dolor sit amet',
            'conference_id' => 1,
            'hash' => 'd294be9cdbe1125ffc44b27626391425',
            'ticket_no' => '#4',
            'sns_accounts' => '{"twitter":"tomzohz","github":"admin","facebook":"admin"}',
            'ticket_json' => '{}',
            'created' => '2017-06-11 14:51:29',
            'modified' => '2017-06-11 14:51:29'
        ],
    ];
}
