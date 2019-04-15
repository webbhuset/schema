<?php

namespace Webbhuset\Schema\Composite;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

class StructSchema extends AbstractSchema
{
    const DEFAULT_ALLOW_UNDEFINED   = false;
    const DEFAULT_MISSING           = S::ERROR_ON_MISSING;

    protected $fields;
    protected $allowUndefined;
    protected $missing;


    public function __construct(array $fields, array $args = [])
    {
        parent::__construct($args);

        $this->allowUndefined   = static::DEFAULT_ALLOW_UNDEFINED;
        $this->missing          = static::DEFAULT_MISSING;

        foreach ($fields as $key => $schema) {
            if (!$schema instanceof SchemaInterface) {
                throw new \InvalidArgumentException();
            }
        }

        if (!$fields) {
            throw new \InvalidArgumentException(); // TODO
        }

        $this->fields = $fields;

        foreach ($args as $arg) {
            if (is_array($arg) && isset($arg[S::ARG_KEY_MISSING])) {
                $arg = $arg[S::ARG_KEY_MISSING];

                if (in_array($arg, [S::ERROR_ON_MISSING, S::SKIP_MISSING, S::MISSING_AS_NULL])) {
                    $this->missing = $arg;
                } else {
                    throw new \InvalidArgumentException(); // TODO
                }
            }
        }
    }

    public static function fromArray(array $array): SchemaInterface
    {
        $this->validateArraySchema($array);

        $args = $array['args'];
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['struct']),
            'args' => S::Struct([
                'fields'            => S::Hashmap(S::Scalar(), S::ArraySchema(), [S::MIN(1)]),
                'nullable'          => S::Bool([S::NULLABLE]),
                'missing'           => S::Enum([
                    S::ERROR_ON_MISSING,
                    S::SKIP_MISSING,
                    S::MISSING_AS_NULL,
                ], [S::NULLABLE]),
                'allow_undefined'   => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type'  => 'struct',
            'args'  => [
                'fields'            => array_map(function($schema) {
                    return $schema->toArray();
                }, $this->fields),
                'nullable'          => $this->isNullable,
                'missing'           => $this->missing,
                'allow_undefined'   => $this->allowUndefined,
            ],
        ];
    }

    public function validate($value): array
    {
        if ($errors = parent::validate($value)) {
            return $errors;
        }

        if ($value === null) {
            return [];
        }

        if (!is_array($value)) {
            return ['Value is not an array.'];
        }

        $errors = [];

        foreach ($this->fields as $key => $schema) {
            if (!array_key_exists($key, $value)) {
                switch ($this->missing) {
                    case S::ERROR_ON_MISSING:
                        $errors[$key] = ['Missing value.'];
                        break;

                    case S::SKIP_MISSING:
                        continue 2;

                    case S::MISSING_AS_NULL:
                        $value[$key] = null;
                        break;
                }
            }

            $fieldErrors = $schema->validate($value[$key]);

            if ($fieldErrors) {
                $errors[$key] = $fieldErrors;
            }

            unset($value[$key]);
        }

        if (!$this->allowUndefined) {
            foreach ($value as $key => $val) {
                $errors[$key] = ['Undefined key.'];
            }
        }

        return $errors;
    }
}
