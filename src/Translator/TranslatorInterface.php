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
 *  @file TranslatorInterface.php
 *
 *  The translator interface
 *
 *  @package    Platine\Lang\Translator
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Lang\Translator;

use Platine\Lang\Configuration;
use Platine\Lang\Storage\StorageInterface;

/**
 * Class TranslatorInterface
 * @package Platine\Lang\Translator
 */
interface TranslatorInterface
{
    /**
     * The class constructor
     * @param Configuration|null $config
     * @param StorageInterface|null $storage
     */
    public function __construct(
        ?Configuration $config = null,
        ?StorageInterface $storage = null
    );

    /**
     * Set the current locale
     * @param string $locale
     * @return $this
     */
    public function setLocale(string $locale): self;

    /**
     * Return the current locale
     * @return string
     */
    public function getLocale(): string;

    /**
     * Check whether the current locale is supported
     * @param string $locale
     * @return bool
     */
    public function isLocaleSupported(string $locale): bool;

    /**
     * Return the list of supported locales
     * @return array<int, string>
     */
    public function locales(): array;

    /**
     * The string representation
     * @return string
     */
    public function __toString(): string;

    /**
     * Return the encoding
     * @return string
     */
    public function getEncoding(): string;

    /**
     * Set the locale encoding
     * @param string $encoding
     * @return $this
     */
    public function setEncoding(string $encoding): self;

    /**
     * Set default domain to use
     * @param string $domain
     * @return $this
     */
    public function setDomain(string $domain): self;

    /**
     * Return the default domain
     * @return string
     */
    public function getDomain(): string;

    /**
     * Add new domain
     * @param string $domain
     * @param string|null $path
     * @return $this
     */
    public function addDomain(string $domain, ?string $path = null): self;

    /**
     * Return the list of domain
     * @return array<string, string>
     */
    public function getDomains(): array;

    /**
     * Translation a single message using current domain
     * @param string $message
     * @param array<int, mixed>|mixed $args
     * @return string
     */
    public function tr(string $message, $args = []): string;

    /**
     * Translation a plural message using given domain
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
    ): string;

    /**
     * Translation a single message for the given domain
     * @param string $message
     * @param string $domain
     * @param array<int, mixed>|mixed $args
     * @return string
     */
    public function trd(string $message, string $domain, $args = []): string;

    /**
     * Translation a plural message for the given domain
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
    ): string;
}
