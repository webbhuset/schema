<?php

namespace Webbhuset\Schema;

interface SchemaInterface
{
    static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface;
    static function getArraySchema(): \Webbhuset\Schema\StructSchema;
    function toArray(): array;
    function normalize($value);
    function validate($value): \Webbhuset\Schema\ValidationResult;
}
