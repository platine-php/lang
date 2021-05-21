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
 *  @file Lang.php
 *
 *  The translator main class
 *
 *  @package    Platine\Lang
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Lang;

use Platine\Lang\Translator\TranslatorInterface;

/**
 * Class Lang
 * @package Platine\Lang
 */
class Lang
{

    /**
     * The translator instance
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Create new instance
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Return the translator instance
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::getEncoding
     */
    public function getEncoding(): string
    {
        return $this->translator->getEncoding();
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::setEncoding
     * @return $this
     */
    public function setEncoding(string $encoding): self
    {
        $this->translator->setEncoding($encoding);

        return $this;
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::getLocale
     */
    public function getLocale(): string
    {
        return $this->translator->getLocale();
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::setLocale
     * @return $this
     */
    public function setLocale(string $locale): self
    {
        if ($locale !== $this->getLocale()) {
            $this->translator->setLocale($locale);
        }

        return $this;
    }

    /**
     * Get the language portion of the locale
     * (example: en_EN returns en)
     * @param string|null $locale
     * @return string|null
     */
    public function getLocaleLanguage(?string $locale = null): ?string
    {
        if ($locale === null) {
            $locale = $this->getLocale();
        }

        $locales = explode('_', $locale);

        if (is_array($locales) && isset($locales[0])) {
            return $locales[0];
        }

        return null;
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::setDomain
     * @return $this
     */
    public function setDomain(string $domain): self
    {
        $this->translator->setDomain($domain);

        return $this;
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::getDomain
     */
    public function getDomain(): string
    {
        return $this->translator->getDomain();
    }

    /**
     * {@inhereitdoc}
     */
    public function addDomain(string $domain, ?string $path = null): self
    {
        $this->translator->addDomain($domain, $path);

        return $this;
    }

    /**
     * Return the list of domain
     * @return array<string, string>
     */
    public function getDomains(): array
    {
        return $this->translator->getDomains();
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::locales
     * @return array<int, string>
     */
    public function locales(): array
    {
        return $this->translator->locales();
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::isLocaleSupported
     */
    public function isLocaleSupported(string $locale): bool
    {
        return $this->translator->isLocaleSupported($locale);
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::tr
     * @param string $message
     * @param array<int, mixed>|mixed $args
     * @return string
     */
    public function tr(string $message, $args = []): string
    {
        return $this->translator->tr($message, $args);
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::trp
     * @param string $singular
     * @param string $plural
     * @param int $count
     * @param array<int, mixed>|mixed $args
     * @return string
     */
    public function trp(
        string $singular,
        string $plural,
        int $count,
        $args = []
    ): string {
        return $this->translator->trp(
            $singular,
            $plural,
            $count,
            $args
        );
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::trd
     * @param string $message
     * @param string $domain
     * @param array<int, mixed>|mixed $args
     * @return string
     */
    public function trd(
        string $message,
        string $domain,
        $args = []
    ): string {
        return $this->translator->trd(
            $message,
            $domain,
            $args
        );
    }

    /**
     * {@inhereitdoc}
     * @see TranslatorInterface::trdp
     * @param string $singular
     * @param string $plural
     * @param int $count
     * @param string $domain
     * @param array<int, mixed>|mixed $args
     * @return string
     */
    public function trdp(
        string $singular,
        string $plural,
        int $count,
        string $domain,
        $args = []
    ): string {
        return $this->translator->trdp(
            $singular,
            $plural,
            $count,
            $domain,
            $args
        );
    }
}
