<?php
namespace App\Classes\TicketParser;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class IosdcTicketParser extends TicketParser
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    /**
     *  0: 注文ID
     *  1: 注文時刻
     *  2: 注文内容
     *  3: イベントID
     *  4: イベントタイトル
     *  5: チケットNo.
     *  6: Email
     *  7: フリーフォーム1 名札の表示名 / 半角換算20文字程度まで （全て全角の場合10文字程度まで）
     *  8: フリーフォーム2 名札に印刷するアイコン / Twitterアカウントを@を含めて記入してください
     *  9: フリーフォーム3 学籍番号（早稲田大学 学生チケットのみ）
     * 10: オプション1 Tシャツのサイズ
     * 11: オプション2 パーカーのサイズ（個人スポンサーチケットのみ） / 指定しない場合Tシャツと同じサイズになります。
     * 12: オプション3 iOSDC Japan 2017への参加には、以下のうち1つ以上を満たしている必要があります
     * 13: オプション4 会場では写真およびビデオ撮影を行い、ライブ配信および後日公開されます。
     * 14: オプション5 iOSDC Japan 2017への参加には行動規範への同意が必要です。
     *
     * @param array $record
     * @return array
     */
    private function array2data($record){
        $ticketTypes = [
            'A' => '一般',
            'B' => '個人S',
            'C' => '学生',
            'D' => 'スポンサー',
            'E' => 'スピーカー',
            'F' => 'スタッフ',
            'G' => 'ブース',
            'H' => 'ご招待',
            'I' => 'PRESS',
        ];
        $ticketTypeChar = substr($record[5], 0, 1);
        $tshirt = $record[10];
        if ($ticketTypeChar == 'B'){
            if ($record[11]){
                $parka = $record[11];
            } else {
                $parka = $tshirt;
            }
            $ticketNo = sprintf("%s / %s / %s / %s", $ticketTypes[$ticketTypeChar], $record[5], $tshirt, $parka);
        } else {
            $ticketNo = sprintf("%s / %s / %s", $ticketTypes[$ticketTypeChar], $record[5], $tshirt);
        }


        $snsAccounts = [];
        if (isset($record[12]) and $twitter = $this->normalizeTwitter($record[8])){
            $snsAccounts['twitter'] = $twitter;
        }

        return [
            'mail' => Configure::read('debug')? 'tom@speedstars.jp': $record[6],
            'password' => $record[0],
            'vote_page_view' => 0,
            'sns_accounts' => count($snsAccounts)? json_encode($snsAccounts): null,
            'ticket_json' => json_encode($record),
            'ticket_type' => $ticketTypeChar,
            'ticket_no' => $ticketNo,
            'hash' => sha1(Configure::read('App.hashSalts.user').$ticketNo),
            'name' => $record[7],
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
