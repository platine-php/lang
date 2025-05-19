<?php

/**
 * Platine Lang
 *
 * Platine Lang is a translation library with extensible translator and storage
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2020 Platine Lang
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 *  @file GettextTranslator.php
 *
 *  The gettext translator class
 *
 *  @package    Platine\Lang\Translator
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Lang\Translator;

use Platine\Lang\Configuration;
use Platine\Lang\Exception\LocaleNotSupportedException;
use Platine\Lang\Storage\StorageInterface;

/**
 * @class GettextTranslator
 * @package Platine\Lang\Translator
 */
class GettextTranslator extends BaseTranslator
{
    /**
     * The default domain
     * @var string
     */
    protected string $domain;

    /**
     * The current locale
     * @var string
     */
    protected string $locale;

    /**
     * The locale encoding
     * @var string
     */
    protected string $encoding;

    /**
     * {@inhereitdoc}
     */
    public function __construct(
        ?Configuration $config = null,
        ?StorageInterface $storage = null
    ) {
        parent::__construct($config, $storage);

        $this->domain = $this->storage->getDomain();
        $this->encoding = $this->storage->getEncoding();

        $locale = $this->storage->getLocale();
        $this->setLocale($locale);
        $this->setDomain($this->config->get('domain'));
    }

    /**
     * {@inhereitdoc}
     */
    public function setLocale(string $locale): self
    {
        if ($this->isLocaleSupported($locale) === false) {
            throw new LocaleNotSupportedException(sprintf(
                'Locale [%s] is not supported',
                $locale
            ));
        }

        $localeText = $locale . '.' . $this->getEncoding();
        putenv('LC_ALL=' . $localeText);
        setlocale(LC_ALL, $localeText);

        parent::setLocale($locale);

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function isLocaleSupported(string $locale): bool
    {
        return in_array($locale, $this->locales());
    }

    /**
    * {@inhereitdoc}
    */
    public function __toString(): string
    {
        return $this->getLocale();
    }

    /**
    * {@inhereitdoc}
    */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * {@inhereitdoc}
     */
    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function setDomain(string $domain): self
    {
        parent::setDomain($domain);

        bindtextdomain($domain, $this->config->get('translation_path'));
        bind_textdomain_codeset($domain, $this->getEncoding());

        $this->domain = textdomain($domain);

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function addDomain(string $domain, ?string $path = null): self
    {
        parent::addDomain($domain, $path);

        $domains = $this->storage->getDomains();

        bindtextdomain($domain, $domains[$domain]);
        bind_textdomain_codeset($domain, $this->getEncoding());

        return $this;
    }

    /**
    * {@inhereitdoc}
    */
    public function tr(string $message, mixed $args = []): string
    {
        $translation = gettext($message);

        if (!empty($args)) {
            if (!is_array($args)) {
                $args = array_slice(func_get_args(), 1);
            }

            $translation = vsprintf($translation, $args);
        }

        return $translation;
    }

    /**
     * {@inhereitdoc}
     */
    public function trd(
        string $message,
        string $domain,
        mixed $args = []
    ): string {
        $translation = dgettext($domain, $message);

        if (!empty($args)) {
            if (!is_array($args)) {
                $args = array_slice(func_get_args(), 2);
            }

            $translation = vsprintf($translation, $args);
        }

        return $translation;
    }

    /**
     * {@inhereitdoc}
     */
    public function trdp(
        string $singular,
        string $plural,
        int $count,
        string $domain,
        mixed $args = []
    ): string {
        $translation = dngettext($domain, $singular, $plural, $count);

        if (!empty($args)) {
            if (!is_array($args)) {
                $args = array_slice(func_get_args(), 4);
            }

            $translation = vsprintf($translation, $args);
        }

        return $translation;
    }

    /**
     * {@inhereitdoc}
     */
    public function trp(
        string $singular,
        string $plural,
        int $count,
        mixed $args = []
    ): string {

        $translation = ngettext($singular, $plural, $count);

        if (!empty($args)) {
            if (!is_array($args)) {
                $args = array_slice(func_get_args(), 3);
            }

            $translation = vsprintf($translation, $args);
        }

        return $translation;
    }
}
