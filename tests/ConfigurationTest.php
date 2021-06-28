<?php

declare(strict_types=1);

namespace Platine\Test\Lang;

use InvalidArgumentException;
use Platine\Lang\Configuration;
use Platine\Lang\Storage\MemoryStorage;
use Platine\Lang\Translator\GettextTranslator;
use Platine\Dev\PlatineTestCase;
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
