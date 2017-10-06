<?php

namespace Webbhuset\Data\Schema\FloatType;

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'DecimalType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'DecimalType-5.5.php';
}
