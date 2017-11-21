<?php
use Migrations\AbstractMigration;

class InsertFeedbackEmails extends AbstractMigration
{
    public function up()
    {
        $this->execute('update conferences set
feedback_mail_from = \'no-reply@builderscon.io\',
feedback_mail_from_name = \'builderscon speaker survey\',
feedback_mail_subject = \'Speaker Evaluation Survey | スピーカーへのフィードバックご協力のお願い\', 
feedback_mail_body = \'(English follows Japanese)

builderscon tokyo 2017にご参加誠にありがとうございました！

buildersconでは皆様のフィードバックをスピーカーにとどけるために以下にフィードバック用のフォームを用意しました。後日こちらで記入された内容をまとめ、スピーカーの皆様へ配布する予定です。入力締切は2017年8月末日です。

[vote_url]

上記フォームから聴講されたセッションを選び、"Feedback"ボタンを押してください。表示されたフォームの設問にしたがって、該当のセッションの内容についてのご意見を記入してください。複数のセッションに参加された場合は是非他のセッションについてもご意見をいただけますと幸いです。

皆様の反応はスピーカーにとって、とても重要なものです。お手数ですが、何卒ご入力のほど、よろしくお願いいたします。

builderscon tokyo 2017 運営チーム

---

Thank you for participating in builderscon tokyo 2017!

We have prepared a speaker evaluation survey. We will compile and send your feedback to the speakers once you have completed the form. The deadline for the forms is Aug 31 2017.

[vote_url]

Please click on the link above, and choose the "Feedback" button for the talks that you have attended. Follow the instruction in the form, and complete the survey. If you have attended multiple sessions, please repeat for the other sessions.

Feedback is very important for the speakers. We appreciate you taking your time to complete the survey.

builderscon tokyo 2017 organizer team\' where slug="builderscon-tokyo-2017";');
        $this->execute('update conferences set 
feedback_mail_from = \'no-reply@iosdc.jp\',
feedback_mail_from_name = \'iOSDC Japan 2017\',
feedback_mail_subject = \'iOSDC Japan 2017: アンケートのお願い\', 
feedback_mail_body = \'先日はiOSDC Japan 2017のチケットをご購入いただき、ありがとうございました。

iOSDC Japan 2017では皆様のフィードバックを以下の2つのアンケートでお聞きしています。
次回以降の開催の参考のために、是非ご協力ください。

このメールはPassMarket経由で何らかのチケットを入手された方向けにお送りしています。
複数のチケットを入手された方は1回だけご回答ください。

1）ご来場者アンケート

カンファレンスに関する感想用のアンケートです。

https://docs.google.com/forms/d/e/1FAIpQLSdHpSUFupFYruQ2cQu9HIPvImtQo1t4kuiNlblwCNDyQBGOHg/viewform

回答期限は2017年10月10日13:00です。


2）トークアンケート

みなさまが会場でトークの投票に使ったURLから各トークへのフィードバックを送ることができます。
名札の裏のQRコード、または、以下のURLからフィードバックをお寄せください。

このURLはあなた専用のURLです。SNSなどでシェアーしないよう、ご注意ください。

[vote_url]

回答期限は2017年10月10日13:00です。

上記フォームから参加したトークを選んで"Feedback"ボタンを押し、ご意見を記入ください。
複数のセッションに参加された場合は是非他のセッションについてもご意見をいただけますと幸いです。

皆様の反応はスピーカーにとって、とても重要なものです。
是非ご協力ください。
記入頂いた内容は、後日、スピーカーの皆様へ配布する予定です。

このフォーム、iOSDC開催期間中の9/17 20:00頃まで正常に機能しておらず、会場でフィードバックをご記入頂いた方の分が記録できていませんでした。
ご記入頂いた方、大変申し訳ありません！お手数ですが、もう一度ご記入、お願いできますでしょうか。


最後まで読んで頂きありがとうございます！
どちらのフォームも回答期限は2017年10月10日13:00です！お昼です！
よろしくお願い致します！

iOSDC Japan 2017 運営チーム
\' where slug="iosdc-japan-2017";');
    }
}
