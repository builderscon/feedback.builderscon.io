<?php
namespace App\Controller;

class AdminAppController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'AdminUsers',
                ],
            ], 
            'flash' => [
                'element' => 'error',
                'key' => 'auth'
            ],
            'loginAction' => [
                'controller' => 'Admins',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Admins',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'index',
            ]
        ]);

    }
}
