<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Composite\StructSchema;

interface SchemaInterface
{
    static function fromArray(array $array): SchemaInterface;
    static function getArraySchema(): StructSchema;
    function toArray(): array;
    function validate($value, bool $strict = true);
}
