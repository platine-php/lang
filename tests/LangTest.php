<?php

declare(strict_types=1);

namespace Platine\Test\Lang;

use Platine\Lang\Lang;
use Platine\Lang\Translator\GettextTranslator;
use Platine\Lang\Translator\TranslatorInterface;
use Platine\PlatineTestCase;

/**
 * Lang class tests
 *
 * @group core
 * @group language
 */
class LangTest extends PlatineTestCase
{

    public function testConstructor(): void
    {
        $translator = $this->getMockInstance(GettextTranslator::class);
        $t = new Lang($translator);
        $this->assertInstanceOf(Lang::class, $t);
        $this->assertInstanceOf(TranslatorInterface::class, $t->getTranslator());
        $this->assertEquals($t->getTranslator(), $translator);
    }
}
