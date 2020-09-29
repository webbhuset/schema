<?php

namespace Webbhuset\Schema;

class Constructor
{
    public static function Any(): \Webbhuset\Schema\AnySchema
    {
        return new \Webbhuset\Schema\AnySchema();
    }

    public static function ArraySchema(): \Webbhuset\Schema\ArraySchemaSchema
    {
        return new \Webbhuset\Schema\ArraySchemaSchema();
    }

    public static function Bool(): \Webbhuset\Schema\BoolSchema
    {
        return new \Webbhuset\Schema\BoolSchema();
    }

    public static function Dict(
        \Webbhuset\Schema\SchemaInterface $keySchema,
        \Webbhuset\Schema\SchemaInterface $valueSchema
    ): \Webbhuset\Schema\DictSchema
    {
        return new \Webbhuset\Schema\DictSchema($keySchema, $valueSchema);
    }

    public static function Float(): \Webbhuset\Schema\FloatSchema
    {
        return new \Webbhuset\Schema\FloatSchema();
    }

    public static function Int(): \Webbhuset\Schema\IntSchema
    {
        return new \Webbhuset\Schema\IntSchema();
    }

    public static function Nullable(\Webbhuset\Schema\SchemaInterface $schema): \Webbhuset\Schema\NullableSchema
    {
        return new \Webbhuset\Schema\NullableSchema($schema);
    }

    public static function OneOf(array $schemas): \Webbhuset\Schema\OneOfSchema
    {
        return new \Webbhuset\Schema\OneOfSchema($schemas);
    }

    public static function String(): \Webbhuset\Schema\StringSchema
    {
        return new \Webbhuset\Schema\StringSchema();
    }

    public static function Struct(array $fields): \Webbhuset\Schema\StructSchema
    {
        return new \Webbhuset\Schema\StructSchema($fields);
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        $schema = static::ArraySchema();
        $schema->validate($array);

        $type = $array['type'] ?? null;
        $class = static::getClassFromType($type);

        return $class::fromArray($array);
    }

    public static function getArraySchema(string $type): \Webbhuset\Schema\StructSchema
    {
        $class = static::getClassFromType($type);

        return $class::getArraySchema();
    }

    protected static function getClassFromType(string $type): string
    {
        switch ($type) {
            case 'any':
                return \Webbhuset\Schema\AnySchema::class;
            case 'array_schema':
                return \Webbhuset\Schema\ArraySchemaSchema::class;
            case 'bool':
                return \Webbhuset\Schema\BoolSchema::class;
            case 'dict':
                return \Webbhuset\Schema\DictSchema::class;
            case 'float':
                return \Webbhuset\Schema\FloatSchema::class;
            case 'int':
                return \Webbhuset\Schema\IntSchema::class;
            case 'nullable':
                return \Webbhuset\Schema\NullableSchema::class;
            case 'one_of':
                return \Webbhuset\Schema\OneOfSchema::class;
            case 'string':
                return \Webbhuset\Schema\StringSchema::class;
            case 'struct':
                return \Webbhuset\Schema\StructSchema::class;
            default:
                throw new \InvalidArgumentException("Unknown type '{$type}'.");
        }
    }
}
