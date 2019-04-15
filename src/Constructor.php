<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Simple;
use Webbhuset\Schema\Composite;

class Constructor
{
    const NULLABLE          = 'NULLABLE';
    const SKIP_EMPTY        = 'SKIP_EMPTY';
    const ALLOW_UNDEFINED   = 'ALLOW_UNDEFINED';
    const CASE_SENSITIVE    = 'CASE_SENSITIVE';
    const CASE_INSENSITIVE  = 'CASE_INSENSITIVE';
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

    public static function SKIP_EMPTY(bool $flag)
    {
        return $flag ? static::SKIP_EMPTY : null;
    }

    public static function ALLOW_UNDEFINED(bool $flag)
    {
        return $flag ? static::ALLOW_UNDEFINED : null;
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

    // Simple schemas

    public static function Bool(array $args = []): Simple\BoolSchema
    {
        return new Simple\BoolSchema($args);
    }

    public static function Enum(array $values, array $args = []): Simple\EnumSchema
    {
        return new Simple\EnumSchema($values, $args);
    }

    public static function Float(array $args = []): Simple\FloatSchema
    {
        return new Simple\FloatSchema($args);
    }

    public static function Int(array $args = []): Simple\IntSchema
    {
        return new Simple\IntSchema($args);
    }

    public static function Scalar(array $args = []): Simple\ScalarSchema
    {
        return new Simple\ScalarSchema($args);
    }

    public static function String(array $args = []): Simple\StringSchema
    {
        return new Simple\StringSchema($args);
    }

    // Composite schemas

    public static function Hashmap(SchemaInterface $keySchema, SchemaInterface $valueSchema, array $args = []): Composite\HashmapSchema
    {
        return new Composite\HashmapSchema($keySchema, $valueSchema, $args);
    }

    public static function Set(SchemaInterface $schema, array $args = []): Composite\SetSchema
    {
        return new Composite\SetSchema($schema, $args);
    }

    public static function Struct(array $fields, array $args = []): Composite\StructSchema
    {
        return new Composite\StructSchema($fields, $args);
    }

    // Utility schemas

    public static function Any(array $args = []): Utility\AnySchema
    {
        return new Utility\AnySchema($args);
    }

    public static function ArraySchema(array $args = []): Utility\ArraySchemaSchema
    {
        return new Utility\ArraySchemaSchema($args);
    }

    // Utility functions

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

    public static function getArraySchema(string $type): Composite\StructSchema
    {
        $class = static::getClassFromType($type);

        return $class::getArraySchema();
    }

    protected static function getClassFromType(string $type)
    {
        switch ($type) {
            case 'bool':
                return Simple\BoolSchema::class;
            case 'enum':
                return Simple\EnumSchema::class;
            case 'float':
                return Simple\FloatSchema::class;
            case 'int':
                return Simple\IntSchema::class;
            case 'string':
                return Simple\StringSchema::class;
            case 'hashmap':
                return Composite\HashmapSchema::class;
            case 'struct':
                return Composite\StructSchema::class;
            case 'any':
                return Utility\AnySchema::class;
            case 'array_schema':
                return Utility\ArraySchemaSchema::class;
            default:
                throw new \InvalidArgumentException();
        }
    }
}
