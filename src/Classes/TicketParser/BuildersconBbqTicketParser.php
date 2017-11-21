<?php
namespace App\Classes\TicketParser;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Class BuildersconBbqTicketParser
 * @package App\Classes\TicketParser
 */
class BuildersconBbqTicketParser extends TicketParser
{
    /*
    [
		(int) 0 => '注文番号',
		(int) 1 => '名前',
		(int) 2 => '表示名',
		(int) 3 => '申込日',
		(int) 4 => 'チケット名',
		(int) 5 => '枚数',
		(int) 6 => 'ステータス',
		(int) 7 => 'コンビニ受付番号',
		(int) 8 => 'チケット番号',
		(int) 9 => 'お子様（13歳未満）の数',
		(int) 10 => 'お持ち込みいただく予定の飲み物・料理等'
	],
     */
    public function __construct($conference)
    {
        parent::__construct($conference);
    }

    private function array2data($record){
        return [
            'mail' => 'tom@speedstars.jp',
            'password' => '99999999',
            'ticket_json' => json_encode($record),
            'ticket_no' => $record[8],
            'hash' => sha1(Configure::read('App.hashSalts.user').$record[0]),
            'conference_id' => $this->conference->id,
        ];
    }

    public function save($records)
    {
        $result_errors = [];
        $successUpdated = 0;
        $successAdded = 0;

        /** @var $usersTable UsersTable */
        $usersTable = TableRegistry::get('Users');
        foreach ($records as $idx => $record){
            $data = $this->array2data($record);

            $isNew = false;
            /** @var $user User  */
            $user = $usersTable->find()->where(['hash' => $data['hash']])->first();
            if (! $user){
                $isNew = true;
                $user = $usersTable->newEntity([]);
            }
            $user = $usersTable->patchEntity($user, $data);

            if (! $errors = $user->getErrors()){
                $usersTable->save($user);
                if ($isNew){
                    $successAdded++;
                } else {
                    $successUpdated++;
                }
            } else {
                $result_errors[] = ['line' => $idx, 'error' => $errors];
            }
        }
        $result = [
            'added' => $successAdded,
            'updated' => $successUpdated,
            'errors' => $result_errors,
        ];

        return $user;
    }
}
