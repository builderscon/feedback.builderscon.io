<?php
namespace App\Test\TestCase\Shell;

use App\Shell\GoogleSpreadsheetDumpShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\GoogleSpreadsheetDumpShell Test Case
 */
class GoogleSpreadsheetDumpShellTest extends TestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \App\Shell\GoogleSpreadsheetDumpShell
     */
    public $GoogleSpreadsheetDump;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->GoogleSpreadsheetDump = new GoogleSpreadsheetDumpShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GoogleSpreadsheetDump);

        parent::tearDown();
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
