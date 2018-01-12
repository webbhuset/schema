<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class AbstractType extends BaseAbstractType
{
    public function __construct(...$args)
    {
        if (count($args) == 1 && ($arg = reset($args)) && is_array($arg) && isset($arg[T::ARG_KEY_ARRAY])) {
            $array = $arg[T::ARG_KEY_ARRAY];

            if ($errors = static::getArraySchema()->getErrors($array)) {
                throw new TypeException('Unable to construct from array', 0, null, $errors);
            }

            $this->constructFromArray($array['args']);
        } else {
            foreach ($args as $arg) {
                $this->parseArg($arg);
            }
        }

        $this->afterConstruct();
    }

    public function toArray(): array
    {
        return static::_toArray();
    }

    public static function getArraySchema(): TypeInterface
    {
        return static::_getArraySchema();
    }

    protected abstract static function _getArraySchema();

    public function isEqual($a, $b): bool
    {
        return static::_isEqual($a, $b);
    }

    protected function getValueString($value): string
    {
        return static::_getValueString($value);
    }

    public function isScalar(): bool
    {
        return static::_isScalar();
    }
}
