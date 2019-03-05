<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

abstract class AbstractSchema implements SchemaInterface
{
    const DEFAULT_NULLABLE = false;

    protected $nullable;


    public function __construct(array $args = [])
    {
        $this->nullable = static::DEFAULT_NULLABLE;

        foreach ($args as $arg) {
            if ($arg === S::NULLABLE) {
                $this->nullable = true;
            }
        }
    }

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

    public function cast($value)
    {
        return $value;
    }

    public function validate($value): array
    {
        if ($value === null and !$this->nullable) {
            return ['Value cannot be null.'];
        }

        return [];
    }
}
