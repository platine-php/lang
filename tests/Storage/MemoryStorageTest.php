<?php

declare(strict_types=1);

namespace Platine\Test\Lang\Storage;

use InvalidArgumentException;
use Platine\Lang\Configuration;
use Platine\Lang\Storage\MemoryStorage;
use Platine\PlatineTestCase;

/**
 * MemoryStorage class tests
 *
 * @group core
 * @group language
 */
class MemoryStorageTest extends PlatineTestCase
{

    public function testConstructor(): void
    {
        $cfg = $this->getMockInstance(Configuration::class);
        $s = new MemoryStorage($cfg);
        $this->assertInstanceOf(Configuration::class, $s->getConfig());
        $this->assertEquals($cfg, $s->getConfig());
    }

    public function testSetGetLocale(): void
    {
        $cfg = $this->getMockInstance(Configuration::class);
        $s = new MemoryStorage($cfg);
        $s->setLocale('my_locale');
        $this->assertEquals('my_locale', $s->getLocale());
    }

    public function testSetGetDomain(): void
    {
        $cfg = $this->getMockInstance(Configuration::class);
        $s = new MemoryStorage($cfg);
        $s->setDomain('my_domain');
        $this->assertEquals('my_domain', $s->getDomain());
    }

    public function testSetGetEncoding(): void
    {
        $cfg = $this->getMockInstance(Configuration::class);
        $s = new MemoryStorage($cfg);
        $s->setEncoding('my_encoding');
        $this->assertEquals('my_encoding', $s->getEncoding());
    }

    public function testAddDomain(): void
    {
        $cfg = $this->getMockInstance(Configuration::class, ['getTranslationPath' => 'my_path']);
        $s = new MemoryStorage($cfg);
        $this->assertCount(0, $s->getDomains());
        $s->addDomain('my_domain');
        $domains = $s->getDomains();
        $this->assertIsArray($domains);
        $this->assertCount(1, $domains);
        $this->assertArrayHasKey('my_domain', $domains);
        $this->assertEquals('my_path', $domains['my_domain']);
    }

    public function testAddDomainAlreadyExists(): void
    {
        $cfg = $this->getMockInstance(Configuration::class, ['getTranslationPath' => 'my_path']);
        $s = new MemoryStorage($cfg);
        $s->addDomain('my_domain');
        $this->expectException(InvalidArgumentException::class);
        $s->addDomain('my_domain');
    }
}
