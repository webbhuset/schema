<?php

namespace Webbhuset\Data\Schema;

use ErrorException;
use ReflectionClass;

class TypeConstructor extends BaseTypeConstructor
{
    public static function NULLABLE($flag)
    {
        return $flag ? self::NULLABLE : null;
    }

    public static function SKIP_EMPTY($flag)
    {
        return $flag ? self::SKIP_EMPTY : null;
    }

    public static function MIN($arg)
    {
        return [self::ARG_KEY_MIN => $arg];
    }

    public static function MAX($arg)
    {
        return [self::ARG_KEY_MAX => $arg];
    }

    public static function MATCH($arg)
    {
        return [self::ARG_KEY_MATCH => $arg];
    }

    public static function NOTMATCH($arg)
    {
        return [self::ARG_KEY_NOTMATCH => $arg];
    }

    public static function CASE_SENSITIVE($flag)
    {
        return $flag ? self::CASE_SENSITIVE : self::CASE_INSENSITIVE;
    }

    public static function DECIMALS($arg)
    {
        return [self::ARG_KEY_DECIMALS => $arg];
    }

    public static function Any()
    {
        $reflection = new ReflectionClass(AnyType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function ArraySchema()
    {
        $reflection = new ReflectionClass(ArraySchemaType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Bool()
    {
        $reflection = new ReflectionClass(BoolType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Date()
    {
        $reflection = new ReflectionClass(StringType\DateType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Datetime()
    {
        $reflection = new ReflectionClass(StringType\DatetimeType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Decimal()
    {
        $reflection = new ReflectionClass(FloatType\DecimalType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Enum()
    {
        $reflection = new ReflectionClass(EnumType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Float()
    {
        $reflection = new ReflectionClass(FloatType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    /**
     * PHP 5.5 compat fix for Function.
     *
     * @param string $name
     * @param array $args
     *
     * @return FunctionType
     */
    public static function __callStatic($name, $args)
    {
        if (strtolower($name) == 'function') {
            $reflection = new ReflectionClass(FunctionType::class);
            $args       = func_get_args();

            return $reflection->newInstanceArgs($args);
        }

        throw new ErrorException(sprintf(
            'Call to undefined method %s::%s()',
            self::class,
            $name
        ));
    }

    public static function Hashmap()
    {
        $reflection = new ReflectionClass(HashmapType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Int()
    {
        $reflection = new ReflectionClass(IntType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Scalar()
    {
        $reflection = new ReflectionClass(ScalarType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Set()
    {
        $reflection = new ReflectionClass(SetType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function String()
    {
        $reflection = new ReflectionClass(StringType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Struct()
    {
        $reflection = new ReflectionClass(StructType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function Union()
    {
        $reflection = new ReflectionClass(UnionType::class);
        $args       = func_get_args();

        return $reflection->newInstanceArgs($args);
    }

    public static function constructFromArray(array $array)
    {
        $type = $array['type'];
        $args = [self::ARG_KEY_ARRAY => $array];

        return self::$type($args);
    }

    public static function getArraySchema($type)
    {
        switch (strtolower($type)) {
            case 'any':
                return AnyType::getArraySchema();
            case 'arrayschema':
                return ArraySchemaType::getArraySchema();
            case 'bool':
                return BoolType::getArraySchema();
            case 'date':
                return StringType\DateType::getArraySchema();
            case 'datetime':
                return StringType\DatetimeType::getArraySchema();
            case 'decimal':
                return FloatType\DecimalType::getArraySchema();
            case 'enum':
                return EnumType::getArraySchema();
            case 'float':
                return FloatType::getArraySchema();
            case 'function':
                return FunctionType::getArraySchema();
            case 'hashmap':
                return HashmapType::getArraySchema();
            case 'int':
                return IntType::getArraySchema();
            case 'scalar':
                return ScalarType::getArraySchema();
            case 'set':
                return SetType::getArraySchema();
            case 'string':
                return StringType::getArraySchema();
            case 'struct':
                return StructType::getArraySchema();
            case 'union':
                return UnionType::getArraySchema();
            default:
                throw new TypeException("Unknown type '{$type}'.");
        }
    }
}
