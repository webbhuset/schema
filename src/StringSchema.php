<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class StringSchema implements \Webbhuset\Schema\SchemaInterface
{
    const DEFAULT_MIN       = null;
    const DEFAULT_MAX       = null;
    const DEFAULT_MATCHES   = [];

    protected $min;
    protected $max;
    protected $regex;
    protected $regexDescription;


    public function min(int $min): self
    {
        if ($this->max !== null && $min > $this->max) {
            throw new \InvalidArgumentException('Min cannot be lower than max.');
        }

        $clone = clone $this;
        $clone->min = $min;

        return $clone;
    }

    public function max(int $max): self
    {
        if ($this->min !== null && $max < $this->min) {
            throw new \InvalidArgumentException('Max cannot be lower than min.');
        }

        $clone = clone $this;
        $clone->max = $max;

        return $clone;
    }

    public function regex(string $regex, ?string $description = ''): self
    {
        $clone = clone $this;
        $clone->regex = $regex;
        $clone->regexDescription = $description;

        return $clone;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        static::getArraySchema()->validate($array);

        $schema = new self();

        if ($array['args']['min']) {
            $schema->min = $array['args']['min'];
        }

        if ($array['args']['max']) {
            $schema->max = $array['args']['max'];
        }

        if ($array['args']['regex']) {
            $schema->regex = $array['args']['regex'];
        }

        if ($array['args']['regex_description']) {
            $schema->regex = $array['args']['regex_description'];
        }

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/string/'),
            'args' => S::Struct([
                'min' => S::Nullable(S::Int()->min(0)),
                'max' => S::Nullable(S::Int()->min(0)),
                'regex' => S::Nullable(S::String()),
                'regex_description' => S::Nullable(S::String()),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'string',
            'args' => [
                'min' => $this->min,
                'max' => $this->max,
                'regex' => $this->regex,
                'regex_description' => $this->regexDescription,
            ],
        ];
    }

    public function validate($value, bool $strict = true): string
    {
        if (!is_string($value)) {
            if ($strict) {
                throw new \Webbhuset\Schema\ValidationException(['Value must be a string.']);
            } elseif ($value === null) {
                $value = '';
            } elseif (is_bool($value)) {
                $value = $value ? '1' : '0';
            } elseif (is_scalar($value)) {
                $value = (string)$value;
            } else {
                throw new \Webbhuset\Schema\ValidationException(['Value must be a scalar.']);
            }
        }

        $strlen = mb_strlen($value);
        if ($this->min !== null && $strlen < $this->min) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must be at least %s character(s).', $this->min),
            ]);
        }

        if ($this->max !== null && $strlen > $this->max) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must be at most %s character(s).', $this->max),
            ]);
        }

        if ($this->regex !== null && !preg_match($this->regex, $value)) {
            if ($this->regexDescription) {
                throw new \Webbhuset\Schema\ValidationException([
                    sprintf('Value must match %s (%s).', $this->regex, $this->regexDescription),
                ]);
            } else {
                throw new \Webbhuset\Schema\ValidationException([
                    sprintf('Value must match %s.', $this->regex),
                ]);
            }
        }

        return $value;
    }
}
