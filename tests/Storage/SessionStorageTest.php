<?php

declare(strict_types=1);

namespace Platine\Test\Lang\Storage;

use Platine\Dev\PlatineTestCase;
use Platine\Lang\Configuration;
use Platine\Lang\Storage\SessionStorage;
use Platine\Session\Session;

/**
 * SessionStorage class tests
 *
 * @group core
 * @group language
 */
class SessionStorageTest extends PlatineTestCase
{
    public function testConstructor(): void
    {
        $cfg = new Configuration([
            'locale' => 'en_US',
            'store_name' => 'app_lang',
            'domain' => 'languages',
            'encoding' => 'UTF-8',
            'translation_path' => '.',
            'locales' => ['en_US']
        ]);

        $session = $this->getMockInstance(Session::class);

        $s = new SessionStorage($session, $cfg);
        $this->assertInstanceOf(Configuration::class, $s->getConfig());
        $this->assertEquals($cfg, $s->getConfig());
        $this->assertEquals($session, $s->getSession());
    }

    public function testSetGetLocale(): void
    {
        $cfg = new Configuration([
            'locale' => 'en_US',
            'store_name' => 'app_lang',
            'domain' => 'languages',
            'encoding' => 'UTF-8',
            'translation_path' => '.',
            'locales' => ['en_US']
        ]);
        $session = $this->getMockInstance(Session::class, [
            'get' => 'foo',
        ]);

        $s = new SessionStorage($session, $cfg);

        $this->expectMethodCallCount($session, 'set', 1);
        $s->setLocale('my_locale');
        $this->assertEquals('foo', $s->getLocale());
    }
}
