<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\SchemaInterface;

class EnumSchema extends AbstractSchema
{
    const DEFAULT_CASE_SENSITIVE = true;

    protected $values;
    protected $caseSensitive;


    public function __construct(array $values, array $args = [])
    {
        parent::__construct($args);

        $this->caseSensitive = static::DEFAULT_CASE_SENSITIVE;

        if (!$values) {
            throw new \InvalidArgumentException();
        }

        foreach ($args as $arg) {
            if ($arg === S::CASE_INSENSITIVE) {
                $this->caseSensitive = false;

                foreach ($values as $value) {
                    if (!is_string($value)) {
                        throw new \InvalidArgumentException();
                    }
                }

                $values = array_map('mb_strtoupper', $values);
            }
        }

        $this->values = $values;
    }

    public static function fromArray(array $array): SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self(
            $args['values'] ?? [],
            [
                S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
                S::NULLABLE($args['case_sensitive'] ?? static::DEFAULT_CASE_SENSITIVE),
            ]
        );
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['enum']),
            'args' => S::Struct([
                'values'            => S::Set(S::Any()),
                'nullable'          => S::Bool([S::NULLABLE]),
                'case_sensitive'    => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'enum',
            'args' => [
                'values'            => $this->values,
                'nullable'          => $this->nullable,
                'case_sensitive'    => $this->caseSensitive,
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

        if ($this->caseSensitive) {
            $inArray = in_array($value, $this->values, true);
        } elseif (is_string($value)) {
            $inArray = in_array(mb_strtoupper($value), $this->values, true);
        } else {
            $inArray = false;
        }

        if (!$inArray) {
            return ['Value is not among the enumerated values.'];
        }

        return [];
    }
}
