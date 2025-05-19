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
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Lang\Storage;

use Platine\Lang\Configuration;
use Platine\Session\Session;

/**
 * @class SessionStorage
 * @package Platine\Lang\Storage
 */
class SessionStorage extends MemoryStorage
{
    /**
     * The Session instance
     * @var Session
     */
    protected Session $session;

    /**
     * The session key to store user language
     * @var string
     */
    protected string $sessionKey;

    /**
     * Create new instance
     * @param Session $session
     * @param Configuration|null $config
     */
    public function __construct(
        Session $session,
        ?Configuration $config = null
    ) {
        parent::__construct($config);
        $this->session = $session;
        $this->sessionKey = $this->config->get('store_name');
    }

    /**
     * {@inhereitdoc}
     */
    public function setLocale(string $locale): self
    {
        $this->session->set($this->sessionKey, $locale);

        return $this;
    }

    /**
     * {@inhereitdoc}
     */
    public function getLocale(): string
    {
        $configLocale = $this->config->get('locale');

        return $this->session->get(
            $this->sessionKey,
            $configLocale
        );
    }

    /**
     * Return the session instance
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}
