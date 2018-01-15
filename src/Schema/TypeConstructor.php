<?php

namespace Webbhuset\Data\Schema;

class BaseTypeConstructor
{
    const NULLABLE          = 'IS_NULLABLE';
    const CASE_SENSITIVE    = 'CASE_SENSITIVE';
    const CASE_INSENSITIVE  = 'CASE_INSENSITIVE';
    const SKIP_EMPTY        = 'SKIP_EMPTY';
    const ALLOW_UNDEFINED   = 'ALLOW_UNDEFINED';
    const ARG_KEY_MIN       = 'KEY_MIN';
    const ARG_KEY_MAX       = 'KEY_MAX';
    const ARG_KEY_MATCH     = 'KEY_MATCH';
    const ARG_KEY_NOTMATCH  = 'KEY_NOTMATCH';
    const ARG_KEY_ARRAY     = 'KEY_ARRAY';
    const ARG_KEY_DECIMALS  = 'KEY_DECIMALS';
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'TypeConstructor-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'TypeConstructor-5.5.php';
}
