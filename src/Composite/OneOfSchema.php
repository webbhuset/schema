<?php

namespace Webbhuset\Schema\Composite;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\SchemaInterface;

class OneOfSchema extends \Webbhuset\Schema\AbstractSchema
{
    protected $schemas;


    public function __construct(array $schemas)
    {
        foreach ($schemas as $schema) {
            if (!$schema instanceof \Webbhuset\Schema\SchemaInterface) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Schema must be instance of \Webbhuset\Schema\SchemaInterface, %s given.',
                        is_object($schema) ? get_class($schema) : gettype($schema)
                    )
                );
            }
        }

        $this->schemas = $schemas;
    }

    public static function fromArray(array $array): SchemaInterface
    {
    }

    public static function getArraySchema(): StructSchema
    {
    }

    public function toArray(): array
    {
    }

    public function validate($value, bool $strict = true)
    {
        $errors = [];

        foreach ($this->schemas as $schema) {
            try {
                return $schema->validate($value, $strict);
            } catch (\Webbhuset\Schema\ValidationException $e) {
                $errors[$key] = $e->getValidationErrors();
            }
        }

        throw new \Webbhuset\Schema\ValidationException($errors);
    }
}
