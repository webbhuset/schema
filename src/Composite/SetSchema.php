<?php

namespace Webbhuset\Schema\Composite;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

class SetSchema extends AbstractSchema
{
    const DEFAULT_MIN = null;
    const DEFAULT_MAX = null;

    protected $schema;
    protected $min;
    protected $max;


    public function __construct(SchemaInterface $schema, array $args = [])
    {
        parent::__construct($args);

        $this->schema   = $schema;
        $this->min      = static::DEFAULT_MIN;
        $this->max      = static::DEFAULT_MAX;

        foreach ($args as $arg) {
            if (is_array($arg) && isset($arg[S::ARG_KEY_MIN]) && is_numeric($arg[S::ARG_KEY_MIN])) {
                $value = (int)$arg[S::ARG_KEY_MIN];
                if ($value < 0) {
                    throw new \InvalidArgumentException();
                }
                $this->min = $value;
            } elseif (is_array($arg) && isset($arg[S::ARG_KEY_MAX]) && is_numeric($arg[S::ARG_KEY_MAX])) {
                $value = (int)$arg[S::ARG_KEY_MAX];
                if ($value < 0) {
                    throw new \InvalidArgumentException();
                }
                $this->max = $value;
            }
        }
    }

    public static function fromArray(array $array): SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self(
            S::fromArray($args['schema'] ?? []),
            [
                S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
                isset($args['min']) ? S::MIN($args['min']) : null,
                isset($args['max']) ? S::MAX($args['max']) : null,
            ]
        );
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['set']),
            'args' => S::Struct([
                'schema'    => S::ArraySchema(),
                'nullable'  => S::Bool([S::NULLABLE]),
                'min'       => S::Int([S::NULLABLE]),
                'max'       => S::Int([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type'  => 'set',
            'args'  => [
                'schema'    => $this->schema->toArray(),
                'nullable'  => $this->nullable,
                'min'       => $this->min,
                'max'       => $this->max,
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

        $size = count($value);

        if ($this->min !== null && $size < $this->min) {
            return [
                sprintf('Value has too few elements, min amount allowed is %s.', $this->min),
            ];
        }

        if ($this->max !== null && $size > $this->max) {
            return [
                sprintf('Value has too many elements, max amount allowed is %s.', $this->max),
            ];
        }

        // TODO: If $this->schema is scalar, ensure uniqueness

        return [];
    }
}
