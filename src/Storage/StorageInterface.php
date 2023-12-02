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
 *  @file StorageInterface.php
 *
 *  The storage class
 *
 *  @package    Platine\Lang\Storage
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Lang\Storage;

/**
 * Class StorageInterface
 * @package Platine\Lang\Storage
 */
interface StorageInterface
{
    /**
     * Set the locale
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
}
