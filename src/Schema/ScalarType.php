<?php

namespace Webbhuset\Data\Schema;

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'ScalarType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'ScalarType-5.5.php';
}
