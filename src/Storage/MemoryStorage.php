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
 *  @file MemoryStorage.php
 *
 *  The memory storage class
 *
 *  @package    Platine\Lang\Storage
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Lang\Storage;

use InvalidArgumentException;
use Platine\Lang\Configuration;

/**
 * Class MemoryStorage
 * @package Platine\Lang\Storage
 */
class MemoryStorage implements StorageInterface
{
    /**
     * The configuration instance
     * @var Configuration
     */
    protected Configuration $config;

    /**
     * The default domain
     * @var string
     */
    protected string $domain;

    /**
     * List of domain currently in use
     * @var array<string, string>
     */
    protected array $domains = [];

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
     * Create new instance
     * @param Configuration|null $config
     */
    public function __construct(?Configuration $config = null)
    {
        $this->config = $config ?? new Configuration([]);
        $this->domain = $this->config->get('domain');
        $this->encoding = $this->config->get('encoding');
        $this->locale = $this->config->get('locale');
    }

    /**
     * Return the configuration
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * {@inhereitdoc}
     */
    public function getDomains(): array
    {
        return $this->domains;
    }

    /**
     * {@inhereitdoc}
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function getLocale(): string
    {
        return $this->locale;
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
        $this->domain = $domain;

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * {@inhereitdoc}
     */
    public function addDomain(string $domain, ?string $path = null): self
    {
        if ($path === null) {
            $path = $this->config->get('translation_path');
        }

        if (isset($this->domains[$domain]) && $this->domains[$domain] !== $path) {
            throw new InvalidArgumentException(sprintf(
                'Domain [%s] already exists',
                $domain
            ));
        }

        $this->domains[$domain] = $path;

        return $this;
    }
}
