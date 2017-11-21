<?php
namespace App\Test\TestCase\Classes\TicketParser;

use App\Classes\TicketParser\TicketParser;
use App\Model\Entity\Conference;
use Cake\TestSuite\TestCase;

class TicketParserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {

    }

    public function testNormalizeTwitter()
    {
        $parser = new TicketParser(new Conference());

        self::assertEquals($parser->normalizeTwitter('https://twitter.com/tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('http://twitter.com/tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('https://mobile.twitter.com/tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('http://mobile.twitter.com/tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('https://mobile.twitter.com/tomzoh/'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('twitter.com/tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('mobile.twitter.com/tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('@tomzoh'), 'tomzoh');
        self::assertEquals($parser->normalizeTwitter('tomzoh'), 'tomzoh');
    }

    public function testNormalizeFacebook()
    {
        $parser = new TicketParser(new Conference());

        self::assertEquals($parser->normalizeFacebook('https://www.facebook.com/hasegawa.tomoki'), 'hasegawa.tomoki');
        self::assertEquals($parser->normalizeFacebook('facebook.com/hasegawa.tomoki'), 'hasegawa.tomoki');
        self::assertEquals($parser->normalizeFacebook('hasegawa.tomoki'), 'hasegawa.tomoki');
        self::assertEquals($parser->normalizeFacebook('https://m.facebook.com/profile.php?lst=100006322935889%3A100006322935889%3A1494292090'), null);
        self::assertEquals($parser->normalizeFacebook('https://m.facebook.com/public/%E9%88%B4%E6%9C%A8-%E5%85%89#~!/hikaru.suzuki.169'), 'hikaru.suzuki.169');
    }

    public function testNormalizeGithub()
    {
        $parser = new TicketParser(new Conference());

        self::assertEquals($parser->normalizeGithub('hasegawa-tomoki'), 'hasegawa-tomoki');
        self::assertEquals($parser->normalizeGithub('http://github.com/hasegawa-tomoki'), 'hasegawa-tomoki');
        self::assertEquals($parser->normalizeGithub('https://github.com/hasegawa-tomoki'), 'hasegawa-tomoki');
        self::assertEquals($parser->normalizeGithub('github.com/hasegawa-tomoki'), 'hasegawa-tomoki');
        self::assertEquals($parser->normalizeGithub('@hasegawa-tomoki'), 'hasegawa-tomoki');
    }
}
