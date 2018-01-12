<?php

namespace Webbhuset\Data\Schema;

interface BaseTypeInterface
{
    function diff($a, $b);
    function cast($value);
    function getErrors($value);
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'TypeInterface-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'TypeInterface-5.5.php';
}
