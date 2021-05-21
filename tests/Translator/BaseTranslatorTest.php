<?php

declare(strict_types=1);

namespace Platine\Test\Lang\Storage;

use Platine\Lang\Configuration;
use Platine\Lang\Exception\LocaleNotSupportedException;
use Platine\Lang\Storage\MemoryStorage;
use Platine\Lang\Translator\GettextTranslator;
use Platine\PlatineTestCase;
use Platine\Test\Fixture\Lang\CustomTranslator;

/**
 * BaseTranslator class tests
 *
 * @group core
 * @group language
 */
class BaseTranslatorTest extends PlatineTestCase
{

    public function testConstructor(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new CustomTranslator($cfg, $storage);
        $this->assertInstanceOf(Configuration::class, $s->getConfig());
        $this->assertEquals($cfg, $s->getConfig());

        $this->assertInstanceOf(MemoryStorage::class, $s->getStorage());
        $this->assertEquals($storage, $s->getStorage());
    }

    public function testGetSetDomain(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new CustomTranslator($cfg, $storage);

        $s->setDomain('my_domain');
        $this->assertEquals('my_domain', $s->getDomain());
    }

    public function testGetSetEncoding(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new CustomTranslator($cfg, $storage);

        $s->setEncoding('my_encoding');
        $this->assertEquals('my_encoding', $s->getEncoding());
    }

    public function testGetSetLocale(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new CustomTranslator($cfg, $storage);

        $s->setLocale('en_US');
        $this->assertEquals('en_US', $s->getLocale());

        //Not same exists
        $s->setLocale('fr_FR');
        $this->assertEquals('fr_FR', $s->getLocale());
        $this->assertEquals('fr_FR', $s->__toString());
    }

    public function testLocaleSupported(): void
    {
        $cfg = new Configuration([]);
        $storage = new MemoryStorage($cfg);
        $s = new CustomTranslator($cfg, $storage);

        $this->assertTrue($s->isLocaleSupported('en_US'));
        $this->assertFalse($s->isLocaleSupported('fr_FR'));
    }
}
