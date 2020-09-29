<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Simple;
use Webbhuset\Schema\Composite;

class Constructor
{
    const NULLABLE          = 'NULLABLE';
    const ERROR_ON_MISSING  = 'ERROR_ON_MISSING';
    const SKIP_MISSING      = 'SKIP_MISSING';
    const MISSING_AS_NULL   = 'MISSING_AS_NULL';
    const ALLOW_UNDEFINED   = 'ALLOW_UNDEFINED';
    const CASE_SENSITIVE    = 'CASE_SENSITIVE';
    const CASE_INSENSITIVE  = 'CASE_INSENSITIVE';
    const ARG_KEY_MISSING   = 'KEY_MISSING';
    const ARG_KEY_MIN       = 'KEY_MIN';
    const ARG_KEY_MAX       = 'KEY_MAX';
    const ARG_KEY_MATCH     = 'KEY_MATCH';
    const ARG_KEY_ARRAY     = 'KEY_ARRAY';
    const ARG_KEY_DECIMALS  = 'KEY_DECIMALS';

    // Args

    public static function NULLABLE(bool $flag)
    {
        return $flag ? static::NULLABLE : null;
    }

    public static function ALLOW_UNDEFINED(bool $flag)
    {
        return $flag ? static::ALLOW_UNDEFINED : null;
    }

    public static function MISSING(string $mode): array
    {
        return [static::ARG_KEY_MISSING => $mode];
    }

    public static function MIN(int $arg): array
    {
        return [static::ARG_KEY_MIN => $arg];
    }

    public static function MAX(int $arg): array
    {
        return [static::ARG_KEY_MAX => $arg];
    }

    public static function MATCH(array $arg): array
    {
        return [static::ARG_KEY_MATCH => $arg];
    }

    public static function CASE_SENSITIVE(bool $flag): string
    {
        return $flag ? static::CASE_SENSITIVE : static::CASE_INSENSITIVE;
    }

    public static function DECIMALS(int $arg): array
    {
        return [static::ARG_KEY_DECIMALS => $arg];
    }

    // \Webbhuset\Schema\Simple schemas

    public static function Bool(array $args = []): \Webbhuset\Schema\Simple\BoolSchema
    {
        return new \Webbhuset\Schema\Simple\BoolSchema($args);
    }

    public static function Enum(array $values, array $args = []): \Webbhuset\Schema\Simple\EnumSchema
    {
        return new \Webbhuset\Schema\Simple\EnumSchema($values, $args);
    }

    public static function Float(array $args = []): \Webbhuset\Schema\Simple\FloatSchema
    {
        return new \Webbhuset\Schema\Simple\FloatSchema($args);
    }

    public static function Int(array $args = []): \Webbhuset\Schema\Simple\IntSchema
    {
        return new \Webbhuset\Schema\Simple\IntSchema($args);
    }

    public static function Scalar(array $args = []): \Webbhuset\Schema\Simple\ScalarSchema
    {
        return new \Webbhuset\Schema\Simple\ScalarSchema($args);
    }

    public static function String(array $args = []): \Webbhuset\Schema\Simple\StringSchema
    {
        return new \Webbhuset\Schema\Simple\StringSchema($args);
    }

    // \Webbhuset\Schema\Composite schemas

    public static function Hashmap(SchemaInterface $keySchema, SchemaInterface $valueSchema, array $args = []): \Webbhuset\Schema\Composite\HashmapSchema
    {
        return new \Webbhuset\Schema\Composite\HashmapSchema($keySchema, $valueSchema, $args);
    }

    public static function Set(SchemaInterface $schema, array $args = []): \Webbhuset\Schema\Composite\SetSchema
    {
        return new \Webbhuset\Schema\Composite\SetSchema($schema, $args);
    }

    public static function Struct(array $fields, array $args = []): \Webbhuset\Schema\Composite\StructSchema
    {
        return new \Webbhuset\Schema\Composite\StructSchema($fields, $args);
    }

    // \Webbhuset\Schema\Utility schemas

    public static function Any(array $args = []): \Webbhuset\Schema\Utility\AnySchema
    {
        return new \Webbhuset\Schema\Utility\AnySchema($args);
    }

    public static function ArraySchema(array $args = []): \Webbhuset\Schema\Utility\ArraySchemaSchema
    {
        return new \Webbhuset\Schema\Utility\ArraySchemaSchema($args);
    }

    // \Webbhuset\Schema\Utility functions

    public static function fromArray(array $array): SchemaInterface
    {
        $type = $array['type'] ?? null;

        $schema = static::ArraySchema();

        if ($errors = $schema->validate($array)) {
            throw new \InvalidArgumentException();
        }

        $class = static::getClassFromType($type);

        return $class::fromArray($array);
    }

    public static function getArraySchema(string $type): \Webbhuset\Schema\Composite\StructSchema
    {
        $class = static::getClassFromType($type);

        return $class::getArraySchema();
    }

    protected static function getClassFromType(string $type): string
    {
        switch ($type) {
            case 'bool':
                return \Webbhuset\Schema\Simple\BoolSchema::class;
            case 'enum':
                return \Webbhuset\Schema\Simple\EnumSchema::class;
            case 'float':
                return \Webbhuset\Schema\Simple\FloatSchema::class;
            case 'int':
                return \Webbhuset\Schema\Simple\IntSchema::class;
            case 'string':
                return \Webbhuset\Schema\Simple\StringSchema::class;
            case 'hashmap':
                return \Webbhuset\Schema\Composite\HashmapSchema::class;
            case 'struct':
                return \Webbhuset\Schema\Composite\StructSchema::class;
            case 'any':
                return \Webbhuset\Schema\Utility\AnySchema::class;
            case 'array_schema':
                return \Webbhuset\Schema\Utility\ArraySchemaSchema::class;
            default:
                throw new \InvalidArgumentException("Unknown type '{$type}'.");
        }
    }
}
