<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

class StringSchema extends AbstractSchema
{
    const DEFAULT_MIN       = null;
    const DEFAULT_MAX       = null;
    const DEFAULT_MATCHES   = [];

    protected $min;
    protected $max;
    protected $matches;


    public function __construct(array $args = [])
    {
        $this->min              = static::DEFAULT_MIN;
        $this->max              = static::DEFAULT_MAX;
        $this->matches          = static::DEFAULT_MATCHES;

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
            } elseif (is_array($arg) && isset($arg[S::ARG_KEY_MATCH]) && is_array($arg[S::ARG_KEY_MATCH])) {
                $this->matches = $arg[S::ARG_KEY_MATCH];
            }
        }
    }

    public static function fromArray(array $array): SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self([
            S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
            isset($args['min']) ? S::MIN($args['min']) : null,
            isset($args['max']) ? S::MAX($args['max']) : null,
            isset($args['matches']) ? S::MATCH($args['matches']) : null,
        ]);
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['string']),
            'args' => S::Struct([
                'nullable'  => S::Bool([S::NULLABLE]),
                'min'       => S::Int([S::NULLABLE, S::MIN(0)]),
                'max'       => S::Int([S::NULLABLE, S::MIN(0)]),
                'matches'   => S::Hashmap(S::String(), S::String(), [S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'string',
            'args' => [
                'nullable' => $this->nullable,
                'min' => $this->min,
                'max' => $this->max,
                'matches' => $this->matches,
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
                sprintf('Value must be at least %s characters.', $this->min),
            ]);
        }

        if ($this->max !== null && $strlen > $this->max) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must be at most %s characters.', $this->max),
            ]);
        }

        // TODO: Only allow one
        foreach ($this->matches as $regex => $message) {
            if (!preg_match($regex, $value)) {
                if ($message) {
                    throw new \Webbhuset\Schema\ValidationException([
                        sprintf('Value must match %s (%s).', $regex, $message),
                    ]);
                } else {
                    throw new \Webbhuset\Schema\ValidationException([
                        sprintf('Value must match %s.', $regex),
                    ]);
                }
            }
        }

        return $value;
    }
}
