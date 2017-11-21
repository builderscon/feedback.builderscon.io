<?php
namespace App\Shell;

use Cake\Console\Shell;
use App\Classes\GoogleSpreadSheets;

/**
 * DumpGoogleSpreadsheet shell command.
 */
class DumpGoogleSpreadsheetShell extends Shell
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
        $parser->addArgument('spreadsheet id', ['required' => true, 'help' => __('Spreadsheet id')]);
        $parser->addArgument('sheet name', ['required' => true, 'help' => __('Sheet name')]);

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $spreadsheetId = $this->args[0];
        $sheetName = $this->args[1];

        $data = GoogleSpreadSheets::retrieve($spreadsheetId, $sheetName);
        echo json_encode($data);
        //$this->out($this->OptionParser->help());
    }

    protected function _welcome()
    {

    }
}
