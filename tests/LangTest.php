<?php

declare(strict_types=1);

namespace Platine\Test\Lang;

use Platine\Lang\Configuration;
use Platine\Lang\Lang;
use Platine\Lang\Storage\MemoryStorage;
use Platine\Lang\Translator\TranslatorInterface;
use Platine\Dev\PlatineTestCase;
use Platine\Test\Fixture\Lang\CustomTranslator;

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
        $translator = $this->getMockInstance(CustomTranslator::class);
        $s = new Lang($translator);
        $this->assertInstanceOf(Lang::class, $s);
        $this->assertInstanceOf(TranslatorInterface::class, $s->getTranslator());
        $this->assertEquals($s->getTranslator(), $translator);
    }

    public function testSetGetLocale(): void
    {
        $cfg = new Configuration([
            'locale' => 'en_US',
            'store_name' => 'app_lang',
            'domain' => 'languages',
            'encoding' => 'UTF-8',
            'translation_path' => '.',
            'locales' => ['fr_FR', 'en_US']
        ]);
        $storage = new MemoryStorage($cfg);
        $translator = new CustomTranslator($cfg, $storage);
        $s = new Lang($translator);
        $s->setLocale('fr_FR');
        $this->assertEquals('fr_FR', $s->getLocale());
    }

    public function testGetLocaleLanguage(): void
    {
        global $mock_explode_to_false;

        $cfg = new Configuration([
            'locale' => 'en_US',
            'store_name' => 'app_lang',
            'domain' => 'languages',
            'encoding' => 'UTF-8',
            'translation_path' => '.',
            'locales' => ['fr_FR', 'en_US']
        ]);
        $storage = new MemoryStorage($cfg);
        $translator = new CustomTranslator($cfg, $storage);
        $s = new Lang($translator);
        $lang = $s->getLocaleLanguage('fr_FR');
        $this->assertEquals($lang, 'fr');
        $this->assertEquals($s->getLocaleLanguage(), 'en');

        $mock_explode_to_false = true;
        $this->assertNull($s->getLocaleLanguage('en'));
    }

    public function testSetGetEncoding(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'getEncoding' => 'my_encoding'
        ]);
        $s = new Lang($translator);
        $s->setEncoding('my_encoding');
        $this->assertEquals('my_encoding', $s->getEncoding());
    }

    public function testSetGetDomain(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'getDomain' => 'my_domain'
        ]);
        $s = new Lang($translator);
        $s->setDomain('my_domain');
        $this->assertEquals('my_domain', $s->getDomain());
    }

    public function testAddDomain(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'getDomains' => ['my_domain' => 'my_path']
        ]);
        $s = new Lang($translator);
        $s->addDomain('my_domain');
        $domains = $s->getDomains();
        $this->assertIsArray($domains);
        $this->assertCount(1, $domains);
        $this->assertArrayHasKey('my_domain', $domains);
        $this->assertEquals('my_path', $domains['my_domain']);
    }

    public function testLocales(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'locales' => ['fr' => 'fr_FR']
        ]);
        $s = new Lang($translator);
        $locales = $s->locales();
        $this->assertIsArray($locales);
        $this->assertCount(1, $locales);
        $this->assertArrayHasKey('fr', $locales);
        $this->assertEquals('fr_FR', $locales['fr']);
    }

    public function testLocaleSupportedFalse(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'isLocaleSupported' => false
        ]);
        $s = new Lang($translator);
        $this->assertFalse($s->isLocaleSupported('false'));
    }

    public function testLocaleSupportedTrue(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'isLocaleSupported' => true
        ]);
        $s = new Lang($translator);
        $this->assertTrue($s->isLocaleSupported('true'));
    }

    public function testTranslate(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'tr' => 'Hello world'
        ]);
        $s = new Lang($translator);
        $res = $s->tr('Hello world');
        $expected = 'Hello world';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateUsingFormatedVariadic(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'tr' => 'Hello world 45'
        ]);
        $s = new Lang($translator);
        $res = $s->tr('Hello world %s your age is %d', 'Tony', 45);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateUsingFormatedArray(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'tr' => 'Hello world 45'
        ]);
        $s = new Lang($translator);
        $res = $s->tr('Hello world %s', [45]);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomain(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trd' => 'Hello world'
        ]);
        $s = new Lang($translator);
        $res = $s->trd('Hello world', 'my_domain');
        $expected = 'Hello world';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomainUsingFormatedVariadic(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trd' => 'Hello world 45'
        ]);
        $s = new Lang($translator);
        $res = $s->trd('Hello world %s', 'my_domain', 45);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomainUsingFormatedArray(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trd' => 'Hello world 45'
        ]);
        $s = new Lang($translator);
        $res = $s->trd('Hello world %s', 'my_domain', [45]);
        $expected = 'Hello world 45';
        $this->assertEquals($expected, $res);
    }

    public function testTranslateInlineDomainSingular(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trdp' => 'Singular'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trdp('Singular', 'Plural', 1, 'my_domain');
        $expected1 = 'Singular';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslateInlineDomainPlural(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trdp' => 'Plural'
        ]);
        $s = new Lang($translator);

        $res2 = $s->trdp('Singular', 'Plural', 2, 'my_domain');
        $expected2 = 'Plural';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslateInlineDomainPluralUsingFormatedVariadic(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trdp' => 'Singular 1'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trdp('Singular %s', 'Plural %s', 1, 'my_domain', 1);
        $expected1 = 'Singular 1';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslateInlineDomainSingularUsingFormatedVariadic(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trdp' => 'Singular 1'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trdp('Singular %s', 'Plural %s', 1, 'my_domain', 1);
        $expected1 = 'Singular 1';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslateInlineDomainSingularUsingFormatedArray(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trdp' => 'Singular 10'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trdp('Singular %s', 'Plural %s', 1, 'my_domain', [10]);
        $expected1 = 'Singular 10';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslateInlineDomainPluralUsingFormatedArray(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trdp' => 'Plural 20'
        ]);
        $s = new Lang($translator);

        $res2 = $s->trdp('Singular %s', 'Plural %s', 2, 'my_domain', [20]);
        $expected2 = 'Plural 20';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslateSingular(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trp' => 'Singular'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trp('Singular', 'Plural', 1);
        $expected1 = 'Singular';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslatePlural(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trp' => 'Plural'
        ]);
        $s = new Lang($translator);

        $res2 = $s->trp('Singular', 'Plural', 2);
        $expected2 = 'Plural';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslateSingularUsingFormatedVariadic(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trp' => 'Singular 1'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trp('Singular %s', 'Plural %s', 1, 1);
        $expected1 = 'Singular 1';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslatePluralUsingFormatedVariadic(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trp' => 'Plural 2'
        ]);
        $s = new Lang($translator);
        $res2 = $s->trp('Singular %s', 'Plural %s', 2, 2);
        $expected2 = 'Plural 2';
        $this->assertEquals($expected2, $res2);
    }

    public function testTranslateSingularUsingFormatedArray(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trp' => 'Singular 10'
        ]);
        $s = new Lang($translator);
        $res1 = $s->trp('Singular %s', 'Plural %s', 1, [10]);
        $expected1 = 'Singular 10';
        $this->assertEquals($expected1, $res1);
    }

    public function testTranslatePluralUsingFormatedArray(): void
    {
        $translator = $this->getMockInstance(CustomTranslator::class, [
            'trp' => 'Plural 20'
        ]);
        $s = new Lang($translator);
        $res2 = $s->trp('Singular %s', 'Plural %s', 2, [20]);
        $expected2 = 'Plural 20';
        $this->assertEquals($expected2, $res2);
    }
}
