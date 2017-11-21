<?php
namespace App\Classes\TicketParser;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class BuildersconTicketParser extends TicketParser
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    /**
     *  0: 注文番号
     *  1: 名前
     *  2: 表示名
     *  3: 申込日
     *  4: チケット名
     *  5: 枚数
     *  6: ステータス
     *  7: コンビニ受付番号
     *  8: チケット番号
     *  9: メールアドレス | Your email address
     * 10: Tシャツサイズ | T shirt size
     * 11: 名札表示名 | Preferred Name
     * 12: Your Twitter URL
     * 13: You Github URL
     * 14: Your Facebook URL
     * 15: あなたの年齢を教えて下さい | Your age
     *
     * @param array $record
     * @return array
     */
    private function array2data($record){
        if ($record[6] == '支払確認中'){
            return null;
        }

        $ticketTypes = [
            '一般チケット' => '一般',
            '学生チケット' => '学生',
            '個人スポンサー' => '個人S',
            'スタッフ' => 'スタッフ',
            'スポンサー' => 'スポンサー',
        ];
        $ticketNo = sprintf("%s / %s", $ticketTypes[$record[4]], $record[8]);

        $snsAccounts = [];
        if (isset($record[12]) and $twitter = $this->normalizeTwitter($record[12])){
            $snsAccounts['twitter'] = $twitter;
        }
        if (isset($record[13]) and $github = $this->normalizeGithub($record[13])){
            $snsAccounts['github'] = $github;
        }
        if (isset($record[14]) and $facebook = $this->normalizeFacebook($record[14])){
            $snsAccounts['facebook'] = $facebook;
        }

        return [
            'mail' => Configure::read('debug')? 'tom@speedstars.jp': $record[9],
            'password' => $record[0],
            'vote_page_view' => 0,
            'sns_accounts' => count($snsAccounts)? json_encode($snsAccounts): null,
            'ticket_json' => json_encode($record),
            'ticket_type' => $record[4],
            'ticket_no' => $ticketNo,
            'hash' => sha1(Configure::read('App.hashSalts.user').$ticketNo),
            'name' => $record[11],
            'conference_id' => $this->conference->id,
        ];
    }

    public function save($records)
    {
        $resultErrors = [];
        $successUpdated = 0;
        $successAdded = 0;
        $successSkipped = 0;

        /** @var $usersTable \App\Model\Table\UsersTable */
        $usersTable = TableRegistry::get('Users');

        // Loop with records
        foreach ($records as $idx => $record){
            $data = $this->array2data($record);

            if (! $data){
                $resultErrors[] = [
                    'line' => $idx,
                    'error' => sprintf("Record parse error. (%s)", implode(', ', $record))
                ];
                continue;
            }

            $isNew = false;
            /** @var \App\Model\Entity\User $user */
            $user = $usersTable->find()->where(['hash' => $data['hash']])->first();
            if ($user){
                $successSkipped++;
                continue;
            } else {
                // Create new entity when user not exists
                $isNew = true;
                $user = $usersTable->newEntity([]);
            }
            $user = $usersTable->patchEntity($user, $data);

            // Count success/error records
            if (! $errors = $user->getErrors()){
                $usersTable->save($user);
                if ($isNew){
                    $successAdded++;
                } else {
                    $successUpdated++;
                }
            } else {
                $columnErrors = [];
                foreach ($errors as $field => $fieldError){
                    foreach ($fieldError as $rule => $error){
                        $columnErrors[] = __('{0}: {1}', $field, $error);
                    }
                }
                $resultErrors[] = ['line' => $idx, 'error' => implode("\n", $columnErrors)];
            }
        }
        $result = [
            'added' => $successAdded,
            'updated' => $successUpdated,
            'skipped' => $successSkipped,
            'errors' => $resultErrors,
        ];

        return $result;
    }
}
