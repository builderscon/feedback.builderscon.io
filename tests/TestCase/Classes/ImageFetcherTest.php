<?php
namespace App\Test\TestCase\Classes;

use App\Classes\ImageFetcher;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ImageFetcherTest extends TestCase
{
    public $fixtures = ['app.ImageFetcher/users', 'app.ImageFetcher/conferences'];

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {

    }

    public function testCheckTicketNoIsUnique()
    {
        $conference = TableRegistry::get('Conferences')->find()->order(['id'])->first();
        $imageFetcher = new ImageFetcher($conference);

        self::assertTrue($imageFetcher->checkTicketNoIsUnique());

        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->newEntity();
        $user->mail = 'foo@example.com';
        $user->password = 'foo';
        $user->conference_id = 1;
        $user->hash = 'hash';
        $user->sns_accounts = '{}';
        $user->ticket_no = '#1';
        $usersTable->save($user);
        self::assertFalse($imageFetcher->checkTicketNoIsUnique());
    }

    public function testQrs()
    {
        $conference = TableRegistry::get('Conferences')->find()->order(['id'])->first();
        $imageFetcher = new ImageFetcher($conference);

        $imageFetcher->flushQrs();
        $i = new \GlobIterator($imageFetcher->pathQr.'*.*');
        self::assertEquals($i->count(), 0);
        self::assertFalse(is_file($imageFetcher->pathQr.'#1.png'));

        $imageFetcher->fetchQrs();
        self::assertTrue(is_file($imageFetcher->pathQr.'#1.png'));

    }

    public function testFetchTwitterAvatar()
    {
        $conference = TableRegistry::get('Conferences')->find()->order(['id'])->first();
        $imageFetcher = new ImageFetcher($conference);
        $imageFetcher->flushAvatars();

        // No icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 1])->first();
        self::assertFalse($imageFetcher->fetchTwitterAvatar($user));

        // Regular icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 2])->first();
        self::assertTrue($imageFetcher->fetchTwitterAvatar($user));
        self::assertTrue(is_file($imageFetcher->pathAvatar.'#2.jpg'));
        self::assertEquals(
            file_get_contents($imageFetcher->pathAvatar.'#2.jpg'),
            file_get_contents(TESTS.'Fixture'.DS.'Images'.DS.'twitter-tomzoh.jpg'));

        // Twitter default icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 3])->first();
        self::assertTrue($imageFetcher->fetchTwitterAvatar($user));
        self::assertTrue(is_file($imageFetcher->pathAvatar.'#3.png'));
        self::assertEquals(
            file_get_contents($imageFetcher->pathAvatar.'#3.png'),
            file_get_contents(TESTS.'Fixture'.DS.'Images'.DS.'twitter-default.png'));

        // Twitter not found
        $user = TableRegistry::get('Users')->find()->where(['id' => 4])->first();
        self::assertFalse($imageFetcher->fetchTwitterAvatar($user));

        $imageFetcher->flushAvatars();
    }

    public function testFetchFacebookAvatar()
    {
        $conference = TableRegistry::get('Conferences')->find()->order(['id'])->first();
        $imageFetcher = new ImageFetcher($conference);
        $imageFetcher->flushAvatars();

        // No icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 1])->first();
        self::assertFalse($imageFetcher->fetchFacebookAvatar($user));

        // Regular icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 2])->first();
        self::assertTrue($imageFetcher->fetchFacebookAvatar($user));
        self::assertTrue(is_file($imageFetcher->pathAvatar.'#2.jpg'));
        self::assertEquals(
            file_get_contents($imageFetcher->pathAvatar.'#2.jpg'),
            file_get_contents(TESTS.'Fixture'.DS.'Images'.DS.'facebook-hasegawatomoki.jpg'));

        $imageFetcher->flushAvatars();
    }

    public function testFetchGithubAvatar()
    {
        $conference = TableRegistry::get('Conferences')->find()->order(['id'])->first();
        $imageFetcher = new ImageFetcher($conference);
        $imageFetcher->flushAvatars();

        // No icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 1])->first();
        self::assertFalse($imageFetcher->fetchGithubAvatar($user));

        // Regular icon
        $user = TableRegistry::get('Users')->find()->where(['id' => 2])->first();
        self::assertTrue($imageFetcher->fetchGithubAvatar($user));
        self::assertTrue(is_file($imageFetcher->pathAvatar.'#2.png'));
        self::assertEquals(
            file_get_contents($imageFetcher->pathAvatar.'#2.png'),
            file_get_contents(TESTS.'Fixture'.DS.'Images'.DS.'github-hasegawatomoki.png'));

        $imageFetcher->flushAvatars();
    }
}
