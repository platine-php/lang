<?php

declare(strict_types=1);

namespace Platine\Test\Lang\Storage;

use Platine\Lang\Configuration;
use Platine\Lang\Exception\LocaleNotSupportedException;
use Platine\Lang\Storage\MemoryStorage;
use Platine\Lang\Translator\GettextTranslator;
use Platine\PlatineTestCase;

/**
 * GettextTranslator class tests
 *
 * @group core
 * @group language
 */
class GettextTranslatorTest extends PlatineTestCase
{

    public function testConstructor(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $this->assertInstanceOf(Configuration::class, $s->getConfig());
        $this->assertEquals($cfg, $s->getConfig());

        $this->assertInstanceOf(MemoryStorage::class, $s->getStorage());
        $this->assertEquals($storage, $s->getStorage());
    }

    public function testSetGetLocale(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $s->setLocale('en_US');
        $this->assertEquals('en_US', $s->getLocale());
        $this->assertEquals('en_US', $s->__toString());
    }

    public function testSetLocaleNotSupported(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $this->expectException(LocaleNotSupportedException::class);
        $s->setLocale('not_found_locale');
    }

    public function testSetGetEncoding(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $s->setEncoding('my_encoding');
        $this->assertEquals('my_encoding', $s->getEncoding());
    }

    public function testAddDomain(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $this->assertCount(0, $s->getDomains());
        $s->addDomain('my_domain');
        $domains = $s->getDomains();
        $this->assertIsArray($domains);
        $this->assertCount(1, $domains);
        $this->assertArrayHasKey('my_domain', $domains);
        $this->assertEquals('.', $domains['my_domain']);
    }

    public function testTranslate(): void
    {
        global $mock_gettext_to_same;
        $mock_gettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res = $s->tr('Hello world');
        $expected = 'Hello world';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateUsingFormatedVariadic(): void
    {
        global $mock_gettext_to_same;
        $mock_gettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res = $s->tr('Hello world %s', 45);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateUsingFormatedArray(): void
    {
        global $mock_gettext_to_same;
        $mock_gettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res = $s->tr('Hello world %s', [45]);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomain(): void
    {
        global $mock_dgettext_to_same;
        $mock_dgettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res = $s->trd('Hello world', 'my_domain');
        $expected = 'Hello world';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomainUsingFormatedVariadic(): void
    {
        global $mock_dgettext_to_same;
        $mock_dgettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res = $s->trd('Hello world %s', 'my_domain', 45);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomainUsingFormatedArray(): void
    {
        global $mock_dgettext_to_same;
        $mock_dgettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res = $s->trd('Hello world %s', 'my_domain', [45]);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomainPlural(): void
    {
        global $mock_dngettext_to_same;
        $mock_dngettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res1 = $s->trdp('Singular', 'Plural', 1, 'my_domain');
        $expected1 = 'Singular';
        $this->assertEquals($expected1, $res1);

        $res2 = $s->trdp('Singular', 'Plural', 2, 'my_domain');
        $expected2 = 'Plural';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslateInlineDomainPluralUsingFormatedVariadic(): void
    {
        global $mock_dngettext_to_same;
        $mock_dngettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res1 = $s->trdp('Singular %s', 'Plural %s', 1, 'my_domain', 1);
        $expected1 = 'Singular 1';
        $this->assertEquals($expected1, $res1);

        $res2 = $s->trdp('Singular %s', 'Plural %s', 2, 'my_domain', 2);
        $expected2 = 'Plural 2';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslateInlineDomainPluralUsingFormatedArray(): void
    {
        global $mock_dngettext_to_same;
        $mock_dngettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res1 = $s->trdp('Singular %s', 'Plural %s', 1, 'my_domain', [10]);
        $expected1 = 'Singular 10';
        $this->assertEquals($expected1, $res1);

        $res2 = $s->trdp('Singular %s', 'Plural %s', 2, 'my_domain', [20]);
        $expected2 = 'Plural 20';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslatePlural(): void
    {
        global $mock_dngettext_to_same;
        $mock_dngettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res1 = $s->trp('Singular', 'Plural', 1);
        $expected1 = 'Singular';
        $this->assertEquals($expected1, $res1);

        $res2 = $s->trp('Singular', 'Plural', 2);
        $expected2 = 'Plural';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslatePluralUsingFormatedVariadic(): void
    {
        global $mock_dngettext_to_same;
        $mock_dngettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res1 = $s->trp('Singular %s', 'Plural %s', 1, 1);
        $expected1 = 'Singular 1';
        $this->assertEquals($expected1, $res1);

        $res2 = $s->trp('Singular %s', 'Plural %s', 2, 2);
        $expected2 = 'Plural 2';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslatePluralUsingFormatedArray(): void
    {
        global $mock_dngettext_to_same;
        $mock_dngettext_to_same = true;
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new GettextTranslator($cfg, $storage);
        $res1 = $s->trp('Singular %s', 'Plural %s', 1, [10]);
        $expected1 = 'Singular 10';
        $this->assertEquals($expected1, $res1);

        $res2 = $s->trp('Singular %s', 'Plural %s', 2, [20]);
        $expected2 = 'Plural 20';
        $this->assertEquals($expected2, $res2);
    }
}
