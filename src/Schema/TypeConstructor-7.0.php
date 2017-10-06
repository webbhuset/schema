<?php

namespace Webbhuset\Data\Schema;

class TypeConstructor
{
    const NULLABLE          = 'IS_NULLABLE';
    const CASE_SENSITIVE    = 'CASE_SENSITIVE';
    const CASE_INSENSITIVE  = 'CASE_INSENSITIVE';
    const ARG_KEY_MIN       = 'KEY_MIN';
    const ARG_KEY_MAX       = 'KEY_MAX';
    const ARG_KEY_MATCH     = 'KEY_MATCH';
    const ARG_KEY_NOTMATCH  = 'KEY_NOTMATCH';
    const ARG_KEY_ARRAY     = 'KEY_ARRAY';
    const ARG_KEY_DECIMALS  = 'KEY_DECIMALS';

    public static function NULLABLE(bool $flag)
    {
        return $flag ? self::NULLABLE : null;
    }

    public static function MIN($arg) : array
    {
        return [self::ARG_KEY_MIN => $arg];
    }

    public static function MAX($arg) : array
    {
        return [self::ARG_KEY_MAX => $arg];
    }

    public static function MATCH($arg) : array
    {
        return [self::ARG_KEY_MATCH => $arg];
    }

    public static function NOTMATCH($arg) : array
    {
        return [self::ARG_KEY_NOTMATCH => $arg];
    }

    public static function CASE_SENSITIVE($flag) : string
    {
        return $flag ? self::CASE_SENSITIVE : self::CASE_INSENSITIVE;
    }

    public static function DECIMALS($arg) : array
    {
        return [self::ARG_KEY_DECIMALS => $arg];
    }

    public static function Any(...$args) : AnyType
    {
        return new AnyType(...$args);
    }

    public static function ArraySchema(...$args) : ArraySchemaType
    {
        return new ArraySchemaType(...$args);
    }

    public static function Bool(...$args) : BoolType
    {
        return new BoolType(...$args);
    }

    public static function Date(...$args) : StringType\DateType
    {
        return new StringType\DateType(...$args);
    }

    public static function Datetime(...$args) : StringType\DatetimeType
    {
        return new StringType\DatetimeType(...$args);
    }

    public static function Decimal(...$args) : FloatType\DecimalType
    {
        return new FloatType\DecimalType(...$args);
    }

    public static function Enum(...$args) : EnumType
    {
        return new EnumType(...$args);
    }

    public static function Float(...$args) : FloatType
    {
        return new FloatType(...$args);
    }

    public static function Function(...$args) : FunctionType
    {
        return new FunctionType(...$args);
    }

    public static function Hashmap(...$args) : HashmapType
    {
        return new HashmapType(...$args);
    }

    public static function Int(...$args) : IntType
    {
        return new IntType(...$args);
    }

    public static function Scalar(...$args) : ScalarType
    {
        return new ScalarType(...$args);
    }

    public static function Set(...$args) : SetType
    {
        return new SetType(...$args);
    }

    public static function String(...$args) : StringType
    {
        return new StringType(...$args);
    }

    public static function Struct(...$args) : StructType
    {
        return new StructType(...$args);
    }

    public static function Union(...$args) : UnionType
    {
        return new UnionType(...$args);
    }

    public static function constructFromArray(array $array) : TypeInterface
    {
        $type = $array['type'];
        $args = [self::ARG_KEY_ARRAY => $array];

        return self::$type($args);
    }

    public static function getArraySchema(string $type) : TypeInterface
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
