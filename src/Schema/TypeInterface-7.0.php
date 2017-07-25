<?php

namespace Webbhuset\Data\Schema;

interface TypeInterface
{
    public function __construct();
    public static function getArraySchema() : TypeInterface;
    public function toArray() : array;
    public function cast($value);
    public function getErrors($value);
    public function isEqual($a, $b) : bool;
    public function diff($a, $b);
}
