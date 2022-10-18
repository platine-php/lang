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

use Platine\Stdlib\Config\AbstractConfiguration;

/**
 * Class Configuration
 * @package Platine\Lang
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getValidationRules(): array
    {
        return [
            'locale' => 'string',
            'store_name' => 'string',
            'domain' => 'string',
            'encoding' => 'string',
            'translation_path' => 'string',
            'locales' => 'array'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(): array
    {
        return [
        'locale' => 'en_US',
        'store_name' => 'app_lang',
        'domain' => 'languages',
        'encoding' => 'UTF-8',
        'translation_path' => 'lang',
        'locales' => ['en_US']
        ];
    }
}
