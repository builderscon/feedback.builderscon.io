<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Conferences Controller
 *
 * @property \App\Model\Table\ConferencesTable $Conferences
 */
class ConferencesController extends AdminAppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $conferences = $this->paginate($this->Conferences);

        $this->set(compact('conferences'));
        $this->set('_serialize', ['conferences']);
    }

    /**
     * View method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $conference = $this->Conferences->get($id, [
            'contain' => ['Sessions', 'Users', 'VoteGroups']
        ]);

        $this->set('conference', $conference);
        $this->set('_serialize', ['conference']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $conference = $this->Conferences->newEntity();
        if ($this->request->is('post')) {
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
            if ($this->Conferences->save($conference)) {
                $this->Flash->success(__('The conference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conference could not be saved. Please, try again.'));
        }
        $this->set(compact('conference'));
        $this->set('_serialize', ['conference']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $conference = $this->Conferences->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
            if ($this->Conferences->save($conference)) {
                $this->Flash->success(__('The conference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conference could not be saved. Please, try again.'));
        }
        $this->set(compact('conference'));
        $this->set('_serialize', ['conference']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conference = $this->Conferences->get($id);
        if ($this->Conferences->delete($conference)) {
            $this->Flash->success(__('The conference has been deleted.'));
        } else {
            $this->Flash->error(__('The conference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
