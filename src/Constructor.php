<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Simple;
use Webbhuset\Schema\Composite;

class Constructor
{
    const NULLABLE          = 'NULLABLE';
    const CASE_SENSITIVE    = 'CASE_SENSITIVE';
    const CASE_INSENSITIVE  = 'CASE_INSENSITIVE';
    const SKIP_EMPTY        = 'SKIP_EMPTY';
    const ALLOW_UNDEFINED   = 'ALLOW_UNDEFINED';
    const ARG_KEY_MIN       = 'KEY_MIN';
    const ARG_KEY_MAX       = 'KEY_MAX';
    const ARG_KEY_MATCH     = 'KEY_MATCH';
    const ARG_KEY_ARRAY     = 'KEY_ARRAY';
    const ARG_KEY_DECIMALS  = 'KEY_DECIMALS';

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


    public static function Bool(array $args = []): Simple\BoolSchema
    {
        return new Simple\BoolSchema($args);
    }

    public static function Enum(array $args = []): Simple\EnumSchema
    {
        return new Simple\EnumSchema($args);
    }

    public static function Float(array $args = []): Simple\FloatSchema
    {
        return new Simple\FloatSchema($args);
    }

    public static function Int(array $args = []): Simple\IntSchema
    {
        return new Simple\IntSchema($args);
    }

    public static function String(array $args = []): Simple\StringSchema
    {
        return new Simple\StringSchema($args);
    }

    public static function Hashmap(SchemaInterface $keySchema, SchemaInterface $valueSchema, array $args = []): Composite\HashmapSchema
    {
        return new Composite\HashmapSchema($keySchema, $valueSchema, $args);
    }

    public static function Struct(array $schema, array $args = []): Composite\StructSchema
    {
        return new Composite\StructSchema($schema, $args);
    }
}
