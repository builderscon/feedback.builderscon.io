<?php
use Migrations\AbstractMigration;

class InsertFeedbackReportEmails extends AbstractMigration
{
    public function up()
    {
        $this->execute('update conferences set 
feedback_report_mail_from = \'no-reply@builderscon.io\',
feedback_report_mail_from_name = \'builderscon speaker survey\',
feedback_report_mail_subject = \'builderscon tokyo 2017 - Talk Evaluations\', 
feedback_report_mail_body = \'(English follows Japanese)

builderscon tokyo 2017運営チームです
本メールは会期後に各セッションに対する参加者からのアンケート回答をまとめたものとなります。

（本メールに表示されているテーブルの説明）
以下に表において、各行はアンケートのそれぞれの質問に対応しています。
各列は1から5までの評価を表しています（1が低評価、5が高評価）。 テーブル内のセルの内容は
それぞれの質問対して、該当する評価で回答された数を表わしています。
Q6以降は自由回答ですので、表のあとにそのまま回答が列記されています。

テーブル上ではそれぞれの質問文は割愛されています。以下が質問文となります
Q1 本セッションで扱われている内容について事前にどの程度知っていましたか？
Q2 スピーカーは本セッションで扱われている内容を理解しているようでしたか？
Q3 スピーカーのプレゼンテーション技術はよかったですか？
Q4 スピーカーのプレゼンテーション資料（スライド、デモ等）はよかったですか？
Q5 セッション全体の評価を教えてください

---

Hi,

In this email, please find the feedback received from the surveys available for builderscon tokyo 2017.

An Explanation of the Tables:

For the table matrix below, each row represents the question asked of the respondee,
with the columns representing the rating given, graded from 1 to 5, where 1 represents
a low rating and 5 a high one. The values in each cell represent the number of respondees
who rated the question with a particular value.
Questions 6 on are free text answers, so they are listed separately.

Due to space restrictions, the text of each question has been truncated. The full text for the questions are as below:

Q1: Your prior knowledge of subject?
Q2: Speaker\'\'s knowledge of subject?
Q3: Speaker\'\'s presentation of subject?
Q4: Quality of presentation materials?
Q5: Overall presentation rating?

[feedbacks]

Regards,

--
builderscon tokyo 2017 organizer team
\' where slug="builderscon-tokyo-2017";');
        $this->execute('update conferences set 
feedback_report_mail_from = \'no-reply@iosdc.jp\',
feedback_report_mail_from_name = \'iOSDC Japan speaker survery\',
feedback_report_mail_subject = \'iOSDC Japan 2017 - トークへのフィードバック\',
feedback_report_mail_body = \'[speaker_name]さん、こんにちは。

先日はiOSDC Japan 2017にスピーカーとしてご参加頂き、ありがとうございました！

iOSDC Japan 2017の開催後、参加者のみなさまからセッションへのフィードバックを募集しました。
本メールは集まったフィードバックのお知らせです。

参加者のみなさまにした質問は以下のとおりです。

[feedback_questions]

Q1〜Q3については1〜5の5段階で入力して頂いており、5がいちばん良い評価です。
Q4, Q5はフリーテキストでの入力でした。

[feedbacks]

iOSDC Japan 2017へのご参加、ありがとうございました。
来年の開催があれば、また、ご参加頂けることを願っています。

iOSDC Japan 2017 運営チーム
\' where slug="iosdc-japan-2017";');

    }
}
