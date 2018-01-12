<?php

namespace Webbhuset\Data\Schema;

interface TypeInterface extends BaseTypeInterface
{
    static function getArraySchema();
    function toArray();
    function isEqual($a, $b);
}
