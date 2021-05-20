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
 *  @file Configuration.php
 *
 *  The language Configuration class
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

use InvalidArgumentException;

/**
 * Class Configuration
 * @package Platine\Lang
 */
class Configuration
{

    /**
     * The translator
     * By default, in the "Gettext".
     * Can be changed for your own translator mechanism
     * @var class-string<\Platine\Lang\Translator\TranslatorInterface>
     */
    protected string $translator;

    /**
     * Key under which the current locale will be stored.
     * @var string
     */
    protected string $sessionKey = 'app_locale';

    /**
     * Default locale: this will be the default for your application.
     * Is to be supposed that all strings are written in this language.
     * @var string
     */
    protected string $locale = 'en_EN';

    /**
     * Default domain used for translations
     * It is the file name
     * @var string
     */
    protected string $domain = 'messages';

    /**
     * Fallback locale
     * When default locale is not available
     * @var string
     */
    protected string $fallbackLocale = 'en_EN';

    /**
     * Supported locales
     * An array containing all allowed languages
     * @var array<int, string>
     */
    protected array $locales = ['en_EN'];

    /**
     * Default character set encoding.
     * @var string
     */
    protected string $encoding = 'UTF-8';

    /**
     * Base translation directory path
     * @var string
     */
    protected string $translationPath = __DIR__;

    /**
     * Where to store the current locale
     *
     * By default, in the session.
     * Can be changed for only memory or your own storage mechanism
     * @var class-string<\Platine\Lang\Storage\StorageInterface>
     */
    protected string $storage;

    /**
     * The raw configuration array
     * @var array<string, mixed>
     */
    protected array $config = [];

    /**
     * Create new instance
     * @param array<string, mixed> $config
     */
    public function __construct(array $config = [])
    {
        $this->load($config);
    }

    /**
     * Return the value of the given configuration
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if (!array_key_exists($name, $this->config)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid configuration [%s]',
                $name
            ));
        }

        return $this->config[$name];
    }

    /**
     * Return the default domain
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Return the translator handler class
     * @return class-string<\Platine\Lang\Translator\TranslatorInterface>
     */
    public function getTranslator(): string
    {
        return $this->translator;
    }

    /**
     * Get the session key to use to save
     * current locale information
     * @return string
     */
    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    /**
     * Get the application default locale
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Return the fallback locales
     * @return string
     */
    public function getFallbackLocale(): string
    {
        return $this->fallbackLocale;
    }

    /**
     * Return the list of supported locales
     * @return array<int, string>
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * Return the encoding used
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * Return the translation directory path
     * @return string
     */
    public function getTranslationPath(): string
    {
        return $this->translationPath;
    }

    /**
     * Return the storage class
     * @return class-string<\Platine\Lang\Storage\StorageInterface>
     */
    public function getStorage(): string
    {
        return $this->storage;
    }

    /**
     * Set the supported locales
     * @param array<int, string> $locales
     * @return $this
     */
    public function setLocales(array $locales): self
    {
        $this->locales = $locales;

        return $this;
    }

    /**
     * Load the configuration
     * @param array<string, mixed> $config
     * @return void
     */
    public function load(array $config): void
    {
        $this->config = $config;

        foreach ($config as $name => $value) {
            $key = str_replace('_', '', lcfirst(ucwords($name, '_')));
            if (property_exists($this, $key)) {
                if (in_array($key, ['locales']) && is_array($value)) {
                    $method = 'set' . ucfirst($key);
                    $this->{$method}($value);
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }
}
