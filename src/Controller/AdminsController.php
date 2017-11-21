<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Admins Controller
 *
 */
class AdminsController extends AdminAppController
{
    public function index()
    {
        $usersTable = TableRegistry::get('Users');
        $users = $usersTable->find()->order(['id' => 'ASC']);

        $conferences = TableRegistry::get('Conferences')->find()->order(['id' => 'ASC']);

        $this->set('title', __('Conferences'));
        $this->set('users', $users);
        $this->set('conferences', $conferences);
    }

    public function nameCards()
    {
        $this->loadModel('Users');
        $users = $this->Users->find()->where(['conference_id' => 1])->order(['Users.id' => 'ASC'])->contain(['Conferences']);

        $this->set('users', $users);
    }



    public function login()
    {
        if ($this->request->is('post')){
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        } else {
            $user = TableRegistry::get('AdminUsers')->newEntity();
        }
        $this->set('user', $user);
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
