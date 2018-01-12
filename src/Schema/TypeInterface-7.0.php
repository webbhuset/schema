<?php

namespace Webbhuset\Data\Schema;

interface TypeInterface extends BaseTypeInterface
{
    static function getArraySchema(): TypeInterface;
    function toArray(): array;
    function isEqual($a, $b): bool;
}
