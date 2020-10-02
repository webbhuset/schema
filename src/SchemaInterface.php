<?php

namespace Webbhuset\Schema;

interface SchemaInterface
{
    static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface;
    static function getArraySchema(): \Webbhuset\Schema\StructSchema;
    function toArray(): array;
    function validate($value, bool $strict = true);
    /* function cast($value) */
    /* function validate2($value); */
}
