<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * AddAdminUser shell command.
 */
class AddAdminUserShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->addArgument('username', ['required' => true, 'help' => __('Username to add')]);
        $parser->addArgument('password', ['required' => true, 'help' => __('Password of this user')]);
        $parser->addArgument('role', ['required' => true, 'help' => __('Role of the user')]);

        $this->loadModel('AdminUsers');

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        //$this->out($this->OptionParser->help());
        $username = $this->args[0];
        $password = $this->args[1];
        $role = $this->args[2];

        // Abort if user already exists.
        if ($this->AdminUsers->find()->where(['username' => $username])->count() > 0){
            return $this->abort('AdminUser '.$username.' already exists.');
        }

        // Create user
        $user = $this->AdminUsers->newEntity();
        $user->username = $username;
        $user->password = $password;
        $user->role = $role;
        $this->AdminUsers->save($user);
    }
}
