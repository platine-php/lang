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
 *  @file BaseTranslator.php
 *
 *  The base translator class
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

use InvalidArgumentException;
use Platine\Lang\Configuration;
use Platine\Lang\Storage\MemoryStorage;
use Platine\Lang\Storage\StorageInterface;

/**
 * Class BaseTranslator
 * @package Platine\Lang\Translator
 */
abstract class BaseTranslator implements TranslatorInterface
{

    /**
     * The configuration instance
     * @var Configuration
     */
    protected Configuration $config;

    /**
     * The configuration instance
     * @var StorageInterface
     */
    protected StorageInterface $storage;

    /**
     * List of domain currently in use
     * @var array<string, string>
     */
    protected array $domains = [];

    /**
     * {@inhereitdoc}
     */
    public function __construct(Configuration $config, ?StorageInterface $storage = null)
    {
        $this->config = $config;
        $this->storage = $storage ? $storage : new MemoryStorage($config);
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
    public function getDomain(): string
    {
        return $this->storage->getDomain();
    }

    /**
     * {@inhereitdoc}
     */
    public function setDomain(string $domain): self
    {
        $this->storage->setDomain($domain);

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function addDomain(string $domain, ?string $path = null): self
    {
        if (isset($this->domains[$domain])) {
            throw new InvalidArgumentException(sprintf(
                'Domain [%s] already exists',
                $domain
            ));
        }

        if ($path === null) {
            $path = $this->config->getTranslationPath();
        }
        $this->domains[$domain] = $path;

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function getEncoding(): string
    {
        return $this->storage->getEncoding();
    }

    /**
     * {@inhereitdoc}
     */
    public function setEncoding(string $encoding): self
    {
        $this->storage->setEncoding($encoding);

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function getLocale(): string
    {
        return $this->storage->getLocale();
    }

    /**
     * {@inhereitdoc}
     */
    public function setLocale(string $locale): self
    {
        if ($locale !== $this->storage->getLocale()) {
            $this->storage->setLocale($locale);
        }

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function isLocaleSupported(string $locale): bool
    {
        return in_array($locale, $this->config->getLocales());
    }

    /**
     * {@inhereitdoc}
     */
    public function locales(): array
    {
        return $this->config->getLocales();
    }
}