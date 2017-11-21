<?php
namespace App\Classes\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;

trait ExtAdminUserTrait {
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
