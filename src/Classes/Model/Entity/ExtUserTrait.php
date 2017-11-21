<?php
namespace App\Classes\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;

trait ExtUserTrait {
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    public function activeSns()
    {
        $snsAccounts = json_decode($this->sns_accounts, true);
        if (isset($snsAccounts['twitter'])){
            return 'twitter';
        }
        if (isset($snsAccounts['github'])){
            return 'github';
        }
        if (isset($snsAccounts['facebook'])){
            return 'facebook';
        }
        return null;
    }

    public function activeSnsAccount()
    {
        $snsAccounts = json_decode($this->sns_accounts, true);
        if (isset($snsAccounts['twitter'])){
            return $snsAccounts['twitter'];
        }
        if (isset($snsAccounts['github'])){
            return $snsAccounts['github'];
        }
        if (isset($snsAccounts['facebook'])){
            return $snsAccounts['facebook'];
        }
        return null;
    }

    public function activeSnsLink()
    {
        $snsAccounts = json_decode($this->sns_accounts, true);
        if (isset($snsAccounts['twitter'])){
            return 'https://twitter.com/'.$snsAccounts['twitter'];
        }
        if (isset($snsAccounts['github'])){
            return 'https://github.com/'.$snsAccounts['github'];
        }
        if (isset($snsAccounts['facebook'])){
            return 'https://facebook.com/'.$snsAccounts['facebook'];
        }
        return null;
    }
}
