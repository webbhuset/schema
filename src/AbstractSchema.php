<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

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

    protected function validateArraySchema(array $array)
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
