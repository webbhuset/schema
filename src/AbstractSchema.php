<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

abstract class AbstractSchema implements SchemaInterface
{
    public static function fromArray(array $array): SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new static([
            S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
        ]);
    }

    protected static function validateArraySchema(array $array)
    {
        $schema = static::getArraySchema();

        if ($errors = $schema->validate($array)) {
            throw new \InvalidArgumentException();
        }
    }
}
