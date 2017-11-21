<?php
namespace App\Test\TestCase\Form;

use App\Form\ImportCsvForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\ImportCsvForm Test Case
 */
class ImportCsvFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Form\ImportCsvForm
     */
    public $ImportCsv;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ImportCsv = new ImportCsvForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ImportCsv);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
