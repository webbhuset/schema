<?php

namespace Webbhuset\Schema\Composite;

use Webbhuset\Schema\Constructor as S;

class DictSchema extends \Webbhuset\Schema\AbstractSchema
{
    const DEFAULT_MIN = null;
    const DEFAULT_MAX = null;

    protected $keySchema;
    protected $valueSchema;
    protected $min;
    protected $max;


    public function __construct(
        \Webbhuset\Schema\SchemaInterface $keySchema,
        \Webbhuset\Schema\SchemaInterface $valueSchema,
        array $args = []
    ) {
        parent::__construct($args);

        $this->keySchema = $keySchema;
        $this->valueSchema = $valueSchema;
        $this->min = static::DEFAULT_MIN;
        $this->max = static::DEFAULT_MAX;

        if (false) { // TODO: Key is not scalar/simple?
            throw new \InvalidArgumentException();
        }

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

        if ($this->min !== null && $this->max !== null && $this->min > $this->max) {
            throw new \InvalidArgumentException();
        }
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self(
            S::fromArray($args['key'] ?? []),
            S::fromArray($args['value'] ?? []),
            [
                S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
                isset($args['min']) ? S::MIN($args['min']) : null,
                isset($args['max']) ? S::MAX($args['max']) : null,
            ]
        );
    }

    public static function getArraySchema(): \Webbhuset\Schema\Composite\StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['hashmap']),
            'args' => S::Struct([
                'key'       => S::ArraySchema(),
                'value'     => S::ArraySchema(),
                'nullable'  => S::Bool([S::NULLABLE]),
                'min'       => S::Int([S::NULLABLE]),
                'max'       => S::Int([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type'  => 'hashmap',
            'args'  => [
                'key'       => $this->keyType->toArray(),
                'value'     => $this->valueType->toArray(),
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

        $errors = [];

        foreach ($value as $k => $v) {
            if ($keyErrors = $this->keySchema->validate($k)) {
                $errors[$k]['key'] = $keyErrors;
            }

            if ($valueErrors = $this->valueSchema->validate($k)) {
                $errors[$k]['value'] = $valueErrors;
            }
        }

        return $errors;
    }
}
