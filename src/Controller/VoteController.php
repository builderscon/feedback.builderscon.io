<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\FeedbackForm;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Votes Controller
 *
 * @property \App\Model\Table\VotesTable $Votes
 */
class VoteController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $userHash = $this->request->getParam('user_hash');
        if (! $userHash){
            throw new NotFoundException();
        }
        $voteGroupSlug = $this->request->getParam('vote_group_slug');

        // Select user
        /** @var \App\Model\Entity\User $user */
        $user = TableRegistry::get('Users')->find()
            ->where(['hash' => $userHash])
            ->contain(['Conferences'])
            ->first();
        $user->vote_page_view += 1;
        TableRegistry::get('Users')->save($user);

        // Find active vote group
        $conditions = ['conference_id' => $user->conference_id];
        if ($voteGroupSlug){
            $conditions['slug'] = $voteGroupSlug;
        }
        $voteGroup = TableRegistry::get('VoteGroups')
            ->find()
            ->where($conditions)
            ->order(['id' => 'ASC'])
            ->first();
        $sessions = TableRegistry::get('Sessions')
            ->find()
            ->contain(['Tracks', 'Speakers', 'Speakers.Users'])
            ->where(['vote_group_id' => $voteGroup->id])
            ->order(['start_at' => 'ASC', 'Tracks.display_order', 'Tracks.id']);

        // Select vote groups
        $voteGroups = TableRegistry::get('VoteGroups')
            ->find()
            ->where(['conference_id' => $user->conference_id])
            ->order(['id' => 'ASC']);

        // Select this user's votes
        $votes = TableRegistry::get('Votes')->find()
            ->where(['user_id' => $user->id, 'VoteGroups.id' => $voteGroup->id])
            ->contain(['Sessions', 'Sessions.VoteGroups']);
        $voteHashes = [];
        foreach ($votes as $vote){
            $voteHashes[] = $vote->session->hash;
        }

        // Select this user's feedbacks
        $feedbackHashes = [];
        $sfs = TableRegistry::get('SessionFeedbacks')->find()
            ->where(['user_id' => $user->id])
            ->contain(['Sessions']);
        foreach ($sfs as $sf){
            $feedbackHashes[] = $sf->session->hash;
        }

        $conference = TableRegistry::get('Conferences')->find()
            ->where(['id' => $user->conference->id])
            ->first();

        $this->set('conference', $conference);
        $this->set('voteGroup', $voteGroup);
        $this->set('voteGroups', $voteGroups);
        $this->set('sessions', $sessions);
        $this->set('user', $user);
        $this->set('voteHashes', $voteHashes);
        $this->set('feedbackHashes', $feedbackHashes);
        $this->set('url', (empty($_SERVER['HTTPS'])? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    }

    private function getUser()
    {
        $userHash = $this->request->getParam('user_hash');
        if (! $userHash){
            throw new NotFoundException();
        }

        /** @var \App\Model\Entity\User $user */
        $user = TableRegistry::get('Users')->find()
            ->where(['hash' => $userHash])
            ->contain(['Conferences'])
            ->first();
        if (! $user){
            throw new NotFoundException();
        }

        return $user;
    }

    private function getSession()
    {
        $sessionHash = $this->request->getParam('session_hash');
        if (! $sessionHash){
            throw new NotFoundException();
        }

        /** @var \App\Model\Entity\Session $session */
        $session = TableRegistry::get('Sessions')
            ->find()
            ->contain(['VoteGroups', 'Speakers', 'Speakers.Users'])
            ->where(['Sessions.hash' => $sessionHash])
            ->first();
        if (! $session){
            throw new NotFoundException();
        }

        return $session;
    }

    public function feedback(){
        $user = $this->getUser();
        $session = $this->getSession();

        /** @var \App\Model\Entity\Conference $conference */
        $conference = TableRegistry::get('Conferences')->find()
            ->where(['id' => $user->conference->id])
            ->first();
        $this->set('conference', $conference);

        $questions = TableRegistry::get('SessionFeedbackQuestions')->find()
            ->where(['conference_id' => $conference->id])
            ->order(['question_no' => 'asc']);
        $this->set('questions', $questions);

        /** @var \App\Form\FeedbackForm $feedbackForm */
        $feedbackForm = new FeedbackForm();
        /** @var \App\Model\Table\SessionFeedbacksTable $sft */
        $sft = TableRegistry::get('SessionFeedbacks');
        /** @var \App\Model\Table\SessionFeedbackAnswersTable $sfat */
        $sfat = TableRegistry::get('SessionFeedbackAnswers');

        if ($this->request->is('post')){
            if ($feedbackForm->execute($this->request->data())){
                /** @var \App\Model\Entity\SessionFeedback $sf */
                if (! ($sf = $sft->find()->where(['user_id' => $user->id, 'session_id' => $session->id])->first())){
                    $sf = $sft->newEntity();
                    $sf->user_id = $user->id;
                    $sf->session_id = $session->id;
                } else {
                    $sfat->deleteAll(['session_feedback_id' => $sf->id]);
                }
                if ($sft->save($sf)){
                    /** @var \App\Model\Entity\SessionFeedbackQuestion $question */
                    foreach ($questions as $question){
                        $data = $this->request->getData(sprintf('q%d', $question->question_no));
                        $sfa = $sfat->newEntity();
                        $sfa->session_feedback_id = $sf->id;
                        $sfa->session_feedback_question_id = $question->id;
                        $sfa->answer = $data;
                        $sfat->save($sfa);
                    }
                }
                $this->Flash->success(__('Feedback submitted.'));
            } else {
                $this->Flash->error(__('Feedback could not be saved. Please, try again.'));
            }
        } else {
            // Restore feedback

            $sf = $sft->find()
                ->where(['user_id' => $user->id, 'session_id' => $session->id])
                ->contain(['SessionFeedbackAnswers', 'SessionFeedbackAnswers.SessionFeedbackQuestions'])
                ->first();
            if ($sf){
                /** @var \App\Model\Entity\SessionFeedbackAnswer $sfa */
                foreach ($sf->session_feedback_answers as $sfa){
                    $this->request->data(sprintf('q%s', $sfa->session_feedback_question->question_no), $sfa->answer);
                }
            }
        }

        $this->set('feedbackForm', $feedbackForm);

        $this->set('user', $user);
        $this->set('session', $session);
    }

    public function sessionsList()
    {
        /** @var \App\Model\Entity\Conference $conference */
        $conference = TableRegistry::get('Conferences')
            ->find()
            ->where(['Conferences.slug' => $this->request->getParam('conference_slug')])
            ->first();
        if (! $conference){
            throw new NotFoundException();
        }

        $sessions = TableRegistry::get('Sessions')
            ->find()
            ->where(['Sessions.conference_id' => $conference->id])
            ->order(['Sessions.start_at', 'Tracks.display_order', 'Tracks.id'])
            ->contain(['Speakers', 'Tracks', 'Speakers.Users']);
        foreach ($sessions as $session){
            if (isset($session->speaker->user->avatar_icon_filename) and $session->speaker->user->avatar_icon_filename){
                $session->speaker->icon_url = sprintf('%s/files/%s/avatar/%s', $conference->vote_url_base, $conference->slug, urlencode($session->speaker->user->avatar_icon_filename));
            }
        }
        $this->set('sessions', $sessions);
    }

    public function post()
    {
        $userHash = $this->request->getParam('user_hash');
        $sessionHash = $this->request->getParam('session_hash');

        /** @var \App\Model\Entity\Session $session */
        $session = TableRegistry::get('Sessions')
            ->find()
            ->contain(['VoteGroups'])
            ->where(['hash' => $sessionHash])
            ->first();
        /** @var \App\Model\Entity\User $user */
        $user = TableRegistry::get('Users')->find()->where(['hash' => $userHash])->first();

        // Check if already voted
        /** @var \App\Model\Entity\Vote $vote */
        $vote = TableRegistry::get('Votes')->find()->where([
            'session_id' => $session->id,
            'user_id' => $user->id,
        ])->first();
        $votesTable = TableRegistry::get('Votes');
        if (! $vote){
            $vote = $votesTable->newEntity();
            $vote->session_id = $session->id;
            $vote->user_id = $user->id;
            $votesTable->save($vote);

            $session->number_of_votes = TableRegistry::get('Votes')->find()->where(['session_id' => $session->id])->count();
            TableRegistry::get('Sessions')->save($session);
        }

        //$this->redirect('/vote/'.$user->hash);
        $this->set([
            'result' => 'success',
            'user' => [
                'hash' => $userHash,
            ],
            'session' => [
                'hash' => $sessionHash,
                'voted' => true,
            ],
            'voted' => $votesTable->find()->where(['user_id' => $user->id])->count(),
            'votingCards' => $session->vote_group->voting_cards,
        ]);
    }

    public function cancel()
    {
        $userHash = $this->request->getParam('user_hash');
        $sessionHash = $this->request->getParam('session_hash');

        /** @var \App\Model\Entity\Session $session */
        $session = TableRegistry::get('Sessions')
            ->find()
            ->contain(['VoteGroups'])
            ->where(['hash' => $sessionHash])
            ->first();
        /** @var \App\Model\Entity\User $user */
        $user = TableRegistry::get('Users')->find()->where(['hash' => $userHash])->first();

        // Get vote entity
        /** @var \App\Model\Entity\Vote $vote */
        $vote = TableRegistry::get('Votes')->find()->where([
            'session_id' => $session->id,
            'user_id' => $user->id,
        ])->first();
        $votesTable = TableRegistry::get('Votes');
        if ($vote){
            $votesTable->delete($vote);

            $session->number_of_votes = TableRegistry::get('Votes')->find()->where(['session_id' => $session->id])->count();
            TableRegistry::get('Sessions')->save($session);
        }

        //$this->redirect('/vote/'.$user->hash);
        $this->set([
            'result' => 'success',
            'user' => [
                'hash' => $userHash,
            ],
            'session' => [
                'hash' => $sessionHash,
                'voted' => false,
            ],
            'voted' => $votesTable->find()->where(['user_id' => $user->id])->count(),
            'votingCards' => $session->vote_group->voting_cards,
        ]);
    }
}
