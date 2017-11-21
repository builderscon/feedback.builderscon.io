<?php
use Migrations\AbstractMigration;

class AddSessionFeedbackInitialData extends AbstractMigration
{
    public function up()
    {
        $this->execute('update conferences set vote_close_at = "2017-08-06 00:00:00" where slug="builderscon-tokyo-2017";');
        $this->insert('session_feedback_questions', [
            [
                'id' => 1,
                'conference_id' => 1,
                'question_no' => 1,
                'lang' => 'ja',
                'question' => '本セッションで扱われている内容について事前にどの程度知っていましたか？',
                'question_type' => 2,
                'option_json' => '{"label": {"left": "全く知らなかった", "right": "完全に理解していた"}, "levels": 5}',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
            [
                'id' => 2,
                'conference_id' => 1,
                'question_no' => 2,
                'lang' => 'ja',
                'question' => 'スピーカーは本セッションで扱われている内容を理解しているようでしたか？',
                'question_type' => 2,
                'option_json' => '{"label": {"left": "あまり理解していなそうだった", "right": "完全に理解していた"}, "levels": 5}',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
            [
                'id' => 3,
                'conference_id' => 1,
                'question_no' => 3,
                'lang' => 'ja',
                'question' => 'スピーカーのプレゼンテーション技術はよかったですか？',
                'question_type' => 2,
                'option_json' => '{"label": {"left": "あまりよくなかった", "right": "素晴らしかった"}, "levels": 5}',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
            [
                'id' => 4,
                'conference_id' => 1,
                'question_no' => 4,
                'lang' => 'ja',
                'question' => 'スピーカーのプレゼンテーション資料（スライド、デモ等）はよかったですか？',
                'question_type' => 2,
                'option_json' => '{"label": {"left": "あまりよくなかった", "right": "素晴らしかった"}, "levels": 5}',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
            [
                'id' => 5,
                'conference_id' => 1,
                'question_no' => 5,
                'lang' => 'ja',
                'question' => 'セッション全体の評価を教えてください',
                'question_type' => 2,
                'option_json' => '{"label": {"left": "あまりよくなかった", "right": "素晴らしかった"}, "levels": 5}',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
            [
                'id' => 6,
                'conference_id' => 1,
                'question_no' => 6,
                'lang' => 'ja',
                'question' => 'セッションの良かった部分を教えて下さい（任意）',
                'question_type' => 1,
                'option_json' => '',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
            [
                'id' => 7,
                'conference_id' => 1,
                'question_no' => 7,
                'lang' => 'ja',
                'question' => 'セッションをさらに良くするための意見があれば教えて下さい（任意）',
                'question_type' => 1,
                'option_json' => '',
                'created' => '2017-08-07 0:00:00',
                'modified' => '2017-08-07 0:00:00'
            ],
        ]);
        /**
        Q1: 本セッションで扱われている内容について事前にどの程度知っていましたか？
        全く知らなかった 1 2 3 4 5 6 7 8 9 10 完全に理解していた
        Q2: スピーカーは本セッションで扱われている内容を理解しているようでしたか？
        あまり理解していなそうだった 1 .. 10 完全に理解していた
        Q3: スピーカーのプレゼンテーション技術はよかったですか？
        あまりよくなかった 1 .. 10 素晴らしかった
        Q4: スピーカーのプレゼンテーション資料（スライド、デモ等）はよかったですか？
        あまりよくなかった 1 .. 10 素晴らしかった
        Q5: セッション全体の評価を教えてください
        あまりよくなかった 1 .. 10 素晴らしかった
        Q6: セッションの良かった部分を教えて下さい（任意）
        テキストフィールド
        Q7: セッションをさらに良くするための意見があれば教えて下さい（任意）
        テキストフィールド
         */
    }
}
