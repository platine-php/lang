<?php

declare(strict_types=1);

namespace Platine\Lang;

$mock_explode_to_false = false;

function explode(string $separator, string $string)
{
    global $mock_explode_to_false;
    if ($mock_explode_to_false) {
        return false;
    }

    return \explode($separator, $string);
}


namespace Platine\Lang\Translator;

$mock_gettext_to_same = false;
$mock_dgettext_to_same = false;
$mock_dngettext_to_same = false;

function gettext(string $key)
{
    global $mock_gettext_to_same;
    if ($mock_gettext_to_same) {
        return $key;
    }

    return \gettext($key);
}

function dgettext(string $domain, string $message)
{
    global $mock_dgettext_to_same;

    if ($mock_dgettext_to_same) {
        return $message;
    }

    return \dgettext($domain, $message);
}

function dngettext(string $domain, string $singular, string $plural, int $count)
{
    global $mock_dngettext_to_same;

    if ($mock_dngettext_to_same) {
        return $count > 1 ? $plural : $singular;
    }

    return \dngettext($domain, $singular, $plural, $count);
}
