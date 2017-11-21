<?php
namespace App\Controller;

use App\Classes\Importer\PeatixImporter;
use App\Controller\AppController;
use App\Form\ImportCsvForm;
use App\Model\Entity\Conference;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

class ImportPeatixController extends AppController
{
    public function index()
    {
        $importPeatix = new ImportCsvForm();

        if ($this->request->is(['patch', 'post', 'put'])){
            if ($importPeatix->execute($this->request->data())){
                $errors = [];

                // Get conference
                /** @var \App\Model\Table\ConferencesTable $conference */
                $conference_id = $this->request->getData('conference_id');
                $conference = TableRegistry::get('Conferences')->find()->where(['id' => $conference_id])->first();
                if (! $conference){
                    throw new NotFoundException("Conference not found. id: ".$conference_id);
                }

                //debug($importPeatix);
                //debug($this->request->data);

                foreach ($this->request->getData('files') as $file){
                    // Error if the file is not csv
                    if ($file['type'] !== 'text/csv'){
                        $errors[$file['name']] = __('File is not a csv file.');
                        return;
                    }
                    // Import file
                    PeatixImporter::importFile($file['tmp_name']);
                }
            } else {
                $this->Flash->error(__('The vm could not be saved. Please, try again.'));
            }
            $this->render('finish');
            return;
        } else {
            // 初回処理
        }


        $conferences = TableRegistry::get('Conferences')->find('list');

        $this->set('importPeatix', $importPeatix);

        $this->set(compact('conferences'));
        $this->set('_serialize', ['session']);
    }
}
