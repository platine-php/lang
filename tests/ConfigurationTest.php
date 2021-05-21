<?php

declare(strict_types=1);

namespace Platine\Test\Lang;

use InvalidArgumentException;
use Platine\Lang\Configuration;
use Platine\Lang\Storage\MemoryStorage;
use Platine\Lang\Translator\GettextTranslator;
use Platine\PlatineTestCase;
use stdClass;

/**
 * Configuration class tests
 *
 * @group core
 * @group language
 */
class ConfigurationTest extends PlatineTestCase
{

    public function testConstructor()
    {
        $cfg = new Configuration([]);
        $this->assertInstanceOf(Configuration::class, $cfg);
    }

    public function testDefaultValues()
    {
        $cfg = new Configuration([]);
        $this->assertEquals(GettextTranslator::class, $cfg->getTranslator());
        $this->assertEquals('app_locale', $cfg->getSessionKey());
        $this->assertEquals('en_US', $cfg->getLocale());
        $this->assertEquals('messages', $cfg->getDomain());
        $this->assertEquals('UTF-8', $cfg->getEncoding());
        $this->assertEquals('.', $cfg->getTranslationPath());
        $this->assertEquals(MemoryStorage::class, $cfg->getStorage());
        $this->assertIsArray($cfg->getLocales());
        $this->assertCount(1, $cfg->getLocales());
    }

    public function testLoadSuccess()
    {
        $cfg = new Configuration([
            'translator' => stdClass::class,
            'session_key' => 'session_key',
            'locale' => 'fr_FR',
            'domain' => 'languages',
            'encoding' => 'ASCII',
            'translation_path' => 'my_path',
            'storage' => stdClass::class,
            'locales' => ['fr_FR', 'en_US']
        ]);

        $this->assertEquals(stdClass::class, $cfg->getTranslator());
        $this->assertEquals('session_key', $cfg->getSessionKey());
        $this->assertEquals('fr_FR', $cfg->getLocale());
        $this->assertEquals('languages', $cfg->getDomain());
        $this->assertEquals('ASCII', $cfg->getEncoding());
        $this->assertEquals('my_path', $cfg->getTranslationPath());
        $this->assertEquals(stdClass::class, $cfg->getStorage());
        $this->assertIsArray($cfg->getLocales());
        $this->assertCount(2, $cfg->getLocales());
    }

    public function testGetNotFound()
    {
        $this->expectException(InvalidArgumentException::class);
        $cfg = new Configuration([]);
        $cfg->get('not_found_config');
    }

    public function testGetSuccess()
    {
        $cfg = new Configuration(['locale' => 'fr_FR']);
        $this->assertEquals('fr_FR', $cfg->get('locale'));
    }
}
