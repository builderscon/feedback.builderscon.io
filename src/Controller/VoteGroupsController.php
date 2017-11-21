<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * VoteGroups Controller
 *
 * @property \App\Model\Table\VoteGroupsTable $VoteGroups
 */
class VoteGroupsController extends AdminAppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Conferences']
        ];
        $voteGroups = $this->paginate($this->VoteGroups);

        $this->set(compact('voteGroups'));
        $this->set('_serialize', ['voteGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Vote Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $voteGroup = $this->VoteGroups->get($id, [
            'contain' => ['Conferences', 'Sessions']
        ]);

        $this->set('voteGroup', $voteGroup);
        $this->set('_serialize', ['voteGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $voteGroup = $this->VoteGroups->newEntity();
        if ($this->request->is('post')) {
            $voteGroup = $this->VoteGroups->patchEntity($voteGroup, $this->request->getData());
            if ($this->VoteGroups->save($voteGroup)) {
                $this->Flash->success(__('The vote group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vote group could not be saved. Please, try again.'));
        }
        $conferences = $this->VoteGroups->Conferences->find('list', ['limit' => 200]);
        $this->set(compact('voteGroup', 'conferences'));
        $this->set('_serialize', ['voteGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vote Group id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $voteGroup = $this->VoteGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $voteGroup = $this->VoteGroups->patchEntity($voteGroup, $this->request->getData());
            if ($this->VoteGroups->save($voteGroup)) {
                $this->Flash->success(__('The vote group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vote group could not be saved. Please, try again.'));
        }
        $conferences = $this->VoteGroups->Conferences->find('list', ['limit' => 200]);
        $this->set(compact('voteGroup', 'conferences'));
        $this->set('_serialize', ['voteGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vote Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $voteGroup = $this->VoteGroups->get($id);
        if ($this->VoteGroups->delete($voteGroup)) {
            $this->Flash->success(__('The vote group has been deleted.'));
        } else {
            $this->Flash->error(__('The vote group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
