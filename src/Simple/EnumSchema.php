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

                $values = array_map('mb_strtoupper', $value);
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

    }

    public function toArray(): array
    {
        return [
            'type' => 'enum',
            'args' => [
                'nullable'          => $this->nullable,
                'values'            => $this->values,
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

        return [];
    }
}
