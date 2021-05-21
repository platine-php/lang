<?php

declare(strict_types=1);

namespace Platine\Test\Fixture\Lang;

use Platine\Lang\Translator\BaseTranslator;

class CustomTranslator extends BaseTranslator
{


    public function tr(string $message, $args = array()): string
    {
        return '';
    }

    public function trd(string $message, string $domain, $args = array()): string
    {
        return '';
    }

    public function trdp(
        string $singular,
        string $plural,
        int $count,
        string $domain,
        $args = []
    ): string {
        return '';
    }

    public function trp(
        string $singular,
        string $plural,
        int $count,
        $args = []
    ): string {
        return '';
    }
}
