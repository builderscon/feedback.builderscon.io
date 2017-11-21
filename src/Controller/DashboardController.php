<?php
namespace App\Controller;

use App\Classes\ImageFetcher;
use App\Form\ImportCsvForm;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;


class DashboardController extends AdminAppController
{
    /** @var \App\Model\Entity\Conference $conference */
    private $conference;
    /** @var \App\Classes\ImageFetcher $imageFetcher */
    private $imageFetcher;
    /** @var \App\Classes\ExtraAction\ExtraAction $extraAction */
    private $extraAction;

    public function index($tab = 'users')
    {
        // Count avatar files, QR files.
        $i = new \GlobIterator($this->imageFetcher->pathQr.'*.*');
        try {
            $count = $i->count();
        } catch ( \LogicException $e){
            $count = 0;
        }
        $this->set('count_qrs', $count);
        $i = new \GlobIterator($this->imageFetcher->pathAvatar.'*.*');
        try {
            $count = $i->count();
        } catch ( \LogicException $e){
            $count = 0;
        }
        $this->set('count_avatars', $count);

        $importCsvForm = new ImportCsvForm();
        if ($this->request->is(['patch', 'post', 'put'])){
            if ($importCsvForm->execute($this->request->data())){
                $results = [
                    'added' => 0,
                    'updated' => 0,
                    'skipped' => 0,
                    'errors' => [],
                ];

                foreach ($this->request->getData('files') as $file){
                    // Error if the file is not csv
                    if ($file['type'] !== 'text/csv'){
                        $result['errors'][] = __('File {0} is not a csv file.', $file['name']);
                        continue;
                    }
                    // Import file
                    $className = sprintf("App\\Classes\\TicketImporter\\%sTicketImporter", $this->conference->class_name);
                    $result = $className::importFile($file['tmp_name'], $this->conference);
                    $results['added'] += $result['added'];
                    $results['updated'] += $result['updated'];
                    $results['skipped'] += $result['skipped'];
                    //debug($result['errors']);
                    if (count($result['errors']) > 0){
                        $results['errors'][$file['name']] = $result['errors'];
                    }
                }
                $this->set('results', $results);
            } else {
                $this->Flash->error(__('The vm could not be saved. Please, try again.'));
            }
        }
        $this->set('importPeatix', $importCsvForm);

        $users = TableRegistry::get('Users')
            ->find()
            ->where(['Users.conference_id' => $this->conference->id])
            ->order(['Users.ticket_type', 'Users.id']);
        $this->set('users', $users);

        // Select sessions
        $sessionConditions = ['Sessions.conference_id' => $this->conference->id];
        if ($voteGroupSlug = $this->request->getQuery('group')){
            $sessionConditions['VoteGroups.slug'] = $voteGroupSlug;
            $activeVoteGroup = TableRegistry::get('VoteGroups')->find()->where(['slug' => $voteGroupSlug])->first();
            $this->set('activeVoteGroup', $activeVoteGroup);
        }
        $sessions = TableRegistry::get('Sessions')
            ->find()
            ->where($sessionConditions)
            ->order(['Sessions.number_of_votes' => 'desc', 'Sessions.start_at', 'Tracks.display_order', 'Tracks.id'])
            ->contain(['Speakers', 'Tracks', 'VoteGroups']);
        $this->set('sessions', $sessions);
        // Select vote groups
        $voteGroups = TableRegistry::get('VoteGroups')->find()->where(['conference_id' => $this->conference->id])->order(['id' => 'asc']);
        $this->set('voteGroups', $voteGroups);

        /** @var \App\Model\Table\SessionFeedbackQuestions $sfqt */
        $sfqt = TableRegistry::get('SessionFeedbackQuestions');
        /** @var \App\Model\Table\SessionFeedbacksTable $sft */
        $sft = TableRegistry::get('SessionFeedbacks');
        /** @var \App\Model\Table\SessionFeedbackAnswersTable $sfat */
        $sfat = TableRegistry::get('SessionFeedbackAnswers');

        $feedbackResults = [];
        foreach ($sessions as $session){
            $feedbacks = $sft->find()->where(['session_id' => $session->id])->order(['id']);
            $resultAnswers = [];
            foreach ($feedbacks as $feedback){
                $answers = $sfat->find()
                    ->where(['session_feedback_id' => $feedback->id])
                    ->contain(['SessionFeedbackQuestions'])
                    ->order(['SessionFeedbackQuestions.question_no']);
                $cols = [];
                foreach ($answers as $answer){
                    $cols[] = $answer;
                }
                $resultAnswers[] = [
                    'feedback' => $feedback,
                    'answers' => $cols,
                ];
            }
            if (count($resultAnswers)){
                $feedbackResults[] = [
                    'session' => $session,
                    'answers' => $resultAnswers,
                ];
            }
        }
        $this->set('feedbackResults', $feedbackResults);

        $feedbackQuestions = $sfqt->find()->where(['conference_id' => $this->conference->id])->order(['question_no']);
        $this->set('feedbackQuestions', $feedbackQuestions);

        $this->set('tab', $tab);
    }

    public function user($hash){
        $user = TableRegistry::get('Users')
            ->find()
            ->where(['hash' => $hash])
            ->contain(['Votes', 'Votes.Sessions'])
            ->first();
        if (! $user){
            throw new NotFoundException();
        }

        $this->set('user', $user);
    }

    public function importSessions()
    {
        $className = sprintf("App\\Classes\\SessionImporter\\%sSessionImporter", $this->conference->class_name);
        $importer = new $className($this->conference);
        $importer->import();
        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug, 'sessions']);
    }

    public function extraAction($actionMethod)
    {
        foreach ($this->extraAction->actions as $action){
            if ($action['method'] == $actionMethod){
                $this->extraAction->$actionMethod();
            }
        }
        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug]);
    }

    public function downloadCsv()
    {
        $csvString = implode(",", [
            'アイコンファイル名',
            '表示名',
            'QRファイル名',
            '種別 / No',
        ]).PHP_EOL;

        $users = TableRegistry::get('Users')
            ->find()
            ->where(['conference_id' => $this->conference->id])
            ->order(['Users.ticket_type', 'Users.id']);

        /** @var \App\Model\Entity\User $user */
        foreach ($users as $user){
            $csvString .= implode(",", [
                $user->avatar_icon_filename? $user->avatar_icon_filename: 'icon_default.eps',
                '"'.$user->name.'"',
                $user->qr_filename,
                $user->ticket_no,
            ]).PHP_EOL;
        }

        $response = $this->response;
        $response->body(mb_convert_encoding($csvString, 'SJIS-win', 'UTF-8'));
        $response = $response->withType('csv');
        $response = $response->withDownload(sprintf("%s-%s.csv", $this->conference->slug, date('Ymd-His')));
        return $response;
    }

    public function sendFeedbackEmail()
    {
        $user = TableRegistry::get('Users')
            ->find()
            ->where(['hash' => $this->request->getQuery('hash')])
            ->first();
        if (! $user){
            throw new NotFoundException();
        }

        $this->sendFeedbackEmailCore($user);

        $this->redirect(['controller' => 'Dashboard', 'action' => 'user', 'conference' => $this->conference->slug, $user->hash]);
    }

    public function createUser()
    {
        $ticketTypeChar = $this->request->data('ticketType');
        $from = $this->request->data('numberFrom');
        $to = $this->request->data('numberTo');

        if ($ticketTypeChar and $from and $to){
            for ($idx = $from; $idx <= $to; $idx++){
                /*
                $data = [
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
                */
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
                $ticketNo = sprintf("%s / %s-%d", $ticketTypes[$ticketTypeChar], $ticketTypeChar, $idx);

                /** @var \App\Model\Table\Users $usersTable */
                $usersTable = TableRegistry::get('Users');
                /** @var \App\Model\Entity\User $user */
                $findUser = $usersTable->find()->where(['ticket_no' => $ticketNo])->first();
                if ($findUser){ continue; }

                /** @var \App\Model\Entity\User $user */
                $user = $usersTable->newEntity();
                $user->mail = 'dummy@iosdc.jp';
                $user->password = sha1(Configure::read('App.hashSalts.user').time());
                $user->vote_page_view = 0;
                $user->sns_accounts = null;
                $user->ticket_json = null;
                $user->ticket_type = $ticketTypeChar;
                $user->ticket_no = $ticketNo;
                $user->hash = sha1(Configure::read('App.hashSalts.user').$ticketNo);
                $user->name = "";
                $user->conference_id = $this->conference->id;

                $usersTable->save($user);
            }
        }

        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug]);
    }

    public function sendFeedbackEmailAll()
    {
        if ($this->request->is('post')) {
            if ($this->request->getData('action') == 'send-emails'){
                $users = TableRegistry::get('Users')
                    ->find()
                    ->where(['conference_id' => $this->conference->id, 'feedback_email_sent' => false]);

                /** @var \App\Model\Entity\User $user */
                foreach ($users as $user){
                    if (in_array($user->mail, ['dummy@example.com', 'foo@example.com', 'dummy@iosdc.jp'])){
                        continue;
                    }
                    $this->sendFeedbackEmailCore($user);
                }
            }
        }
        $this->redirect(['action' => 'index']);
    }

    /**
     * @param \App\Model\Entity\User $user ユーザ
     */
    private function sendFeedbackEmailCore($user)
    {
        $emailText = $this->conference->feedback_mail_body;

        $mail = new Email('default');
        //$mail->setFrom(['no-reply@builderscon.io' => 'builderscon speaker survey'])
        $mail->setFrom([$this->conference->feedback_mail_from => $this->conference->feedback_mail_from_name])
            ->setTo($user->mail)
            ->setSubject($this->conference->feedback_mail_subject);
        $voteUrl = sprintf("%svote/%s", $this->conference->vote_url_base, $user->hash);
        $emailText = str_replace('[vote_url]', $voteUrl, $emailText);
        $mail->send($emailText);

        $user->feedback_email_sent = true;
        TableRegistry::get('Users')->save($user);
    }

    public function sendFeedbackReportEmailAll()
    {
        $sessions = TableRegistry::get('Sessions')->find()->where(['conference_id' => $this->conference->id])->order(['id' => 'asc']);
        foreach ($sessions as $session){
            $this->sendFeedbackReportEmailCore($session);
        }
    }

    public function sendFeedbackReportEmail()
    {
        $hash = $this->request->getQuery('session');
        $session = TableRegistry::get('Sessions')->find()->where(['hash' => $hash])->first();
        if (! $session){
            throw new NotFoundException();
        }

        $this->sendFeedbackReportEmailCore($session, true);
    }

    /**
     * @param \App\Model\Entity\Session $session
     */
    public function sendFeedbackReportEmailCore($session, $single = false)
    {
        $questions = TableRegistry::get('SessionFeedbackQuestions')->find()->where(['conference_id' => $this->conference->id])->order(['question_no' => 'asc']);

        $questionTexts = [];
        $answerNumerics = [];
        $answerNumericsText = null;
        $answerTexts = [];
        $answerTextsText = null;
        $numericHeadersText = [];
        /** @var \App\Model\Entity\SessionFeedbackQuestion $question */
        foreach ($questions as $question){
            if ($question->question_type == 1){
                // Free text
                $answers = TableRegistry::get('SessionFeedbackAnswers')->find()
                    ->where([
                        'session_feedback_question_id' => $question->id,
                        'SessionFeedbacks.session_id' => $session->id,
                    ])
                    ->contain(['SessionFeedbacks', 'SessionFeedbacks.Users'])
                    ->order('SessionFeedbackAnswers.id');
                /** @var \App\Model\Entity\SessionFeedbackAnswer $answer */
                foreach ($answers as $answer){
                    if (! $answer->answer){
                        continue;
                    }
                    if (! isset($answerTexts[$question->question_no])){
                        $answerTexts[$question->question_no] = [];
                    }
                    //debug($answer);
                    $answerTexts[$question->question_no][] = sprintf("%s", $answer->answer);
                }

                $answerTextsText[$question->question_no] = sprintf("Q%d. %s\n\n", $question->question_no, $question->question);
                if (isset($answerTexts[$question->question_no])){
                    $answerTextsText[$question->question_no] .= implode("\n", $answerTexts[$question->question_no])."\n\n";
                }
            }
            if ($question->question_type == 2){
                // Ratings
                $answers = TableRegistry::get('SessionFeedbackAnswers')->find()
                    ->where([
                        'session_feedback_question_id' => $question->id,
                        'SessionFeedbacks.session_id' => $session->id,
                    ])
                    ->contain(['SessionFeedbacks', 'SessionFeedbacks.Users'])
                    ->order('SessionFeedbackAnswers.id');
                $options = json_decode($question->option_json);
                /** @var \App\Model\Entity\SessionFeedbackAnswer $answer */
                foreach ($answers as $answer){
                    if (! $answer->answer){
                        continue;
                    }
                    if (! isset($answerNumerics[$question->question_no])){
                        $answerNumerics[$question->question_no] = [];
                        $numericHeaders = [];
                        for ($idx = 0; $idx < $options->levels; $idx++){
                            $answerNumerics[$question->question_no][$idx] = 0;
                            $numericHeaders[] = sprintf("%4d", $idx + 1);
                        }
                        $numericHeadersText[$question->question_no] = sprintf("     |%s |", implode(" | ", $numericHeaders));
                        $numericHeadersText[$question->question_no] .= "\n".str_pad(null, strlen($numericHeadersText[$question->question_no]), '-');
                    }
                    $answerNumerics[$question->question_no][$answer->answer]++;
                    //debug($answer);
                }
                $numericTexts = [];
                if (isset($answerNumerics[$question->question_no])){
                    foreach ($answerNumerics[$question->question_no] as $count){
                        $numericTexts[] = sprintf("%4d", $count);
                    }
                }
                $questionTexts[] = sprintf("Q%d %s", $question->question_no, $question->question);
                $answerNumericsText[$question->question_no] = sprintf("| Q%d |%s |", $question->question_no, implode(" | ", $numericTexts));
            }
        }

        $emailText = $this->conference->feedback_report_mail_body;
        $emailText = str_replace('[feedback_questions]', implode("\n", $questionTexts), $emailText);
        $numericHeadersTextShift = array_shift($numericHeadersText);
        $emailText = str_replace('[feedbacks]', sprintf("%s\n\n\n%s", $numericHeadersTextShift."\n".implode("\n", $answerNumericsText), implode("\n", $answerTextsText)), $emailText);

        $speaker = TableRegistry::get('Speakers')->find()->where(['Speakers.id' => $session->speaker_id])->contain(['Users'])->first();
        $emailText = str_replace('[speaker_name]', $speaker->name, $emailText);

        $mail = new Email('default');
        //$speaker->user->mail = "hasegawa.tomoki@gmail.com";
        $email = null;
        if ($speaker->user->mail){
            $email = $speaker->user->mail;
        }
        if ($speaker->email) {
            $email = $speaker->email;
        }
        if ($email){
            $mail->setFrom([$this->conference->feedback_report_mail_from => $this->conference->feedback_report_mail_from_name])
                ->setTo($email)
                ->setSubject($this->conference->feedback_report_mail_subject);
            $mail->send($emailText);
        }

        if ($single){
            echo("email sent to ".$email);
            echo("<pre>");
            var_dump($session);
            echo("</pre>");
            echo("<pre>".$emailText."</pre>");
            exit();
        }
    }

    /**
     * fetch*
     */
    public function fetchQrs()
    {
        $this->imageFetcher->fetchQrs();
        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug]);
    }

    public function fetchQr($hash){
        $user = TableRegistry::get('Users')->find()->where(['hash' => $hash])->first();
        if (! $user){
            throw new NotFoundException();
        }
        $this->imageFetcher->fetchQr($user);

        $this->set('user', $user);
        $this->redirect(['action' => 'user', 'conference' => $this->conference->slug, $hash]);
    }

    public function fetchAvatars()
    {
        $this->imageFetcher->fetchAvatars();
        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug]);
    }

    public function fetchAvatar($hash){
        $user = TableRegistry::get('Users')->find()->where(['hash' => $hash])->first();
        if (! $user){
            throw new NotFoundException();
        }
        $this->imageFetcher->fetchAvatar($user);

        $this->set('user', $user);
        $this->redirect(['action' => 'user', 'conference' => $this->conference->slug, $hash]);
    }

    /**
     * flush*
     */
    public function flushAvatars()
    {
        $this->imageFetcher->flushAvatars();
        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug]);
    }

    public function flushQrs()
    {
        $this->imageFetcher->flushQrs();
        $this->redirect(['action' => 'index', 'conference' => $this->conference->slug]);
    }

    /**
     * Controller lifecycle
     */
    public function beforeFilter(Event $event)
    {
        $conference_slug = $this->request->getParam('conference');
        $conference = TableRegistry::get('Conferences')->find()->where(['slug' => $conference_slug])->first();
        if (! $conference){
            throw new NotFoundException('Conference '.$conference_slug.' not found.');
        }
        $this->conference = $conference;
        $this->imageFetcher = new ImageFetcher($this->conference);

        $extraActionClass = sprintf("App\\Classes\\ExtraAction\\%sExtraAction", $this->conference->class_name);
        if (class_exists($extraActionClass)){
            $this->extraAction = new $extraActionClass($this->conference);
        }

        return parent::beforeFilter($event);
    }

    public function beforeRender(Event $event)
    {
        $this->set('conference', $this->conference);
        $this->set('title', $this->conference->name);
        $this->set('extraAction', $this->extraAction);

        parent::beforeRender($event); // TODO: Change the autogenerated stub
    }
}
