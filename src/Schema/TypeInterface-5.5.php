<?php

namespace Webbhuset\Data\Schema;

interface TypeInterface
{
    public function __construct();
    public static function getArraySchema();
    public function toArray();
    public function cast($value);
    public function getErrors($value);
    public function isEqual($a, $b);
    public function diff($a, $b);
}
