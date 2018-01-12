<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class AbstractType extends BaseAbstractType
{
    public function __construct()
    {
        $args = func_get_args();
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

    public function toArray()
    {
        return static::_toArray();
    }

    public static function getArraySchema()
    {
        return static::_getArraySchema();
    }

    protected static function _getArraySchema()
    {
        throw new \BadMethodCallException('Function not overriden in child class.');
    }

    public function isEqual($a, $b)
    {
        return static::_isEqual($a, $b);
    }

    protected function getValueString($value)
    {
        return static::_getValueString($value);
    }

    public function isScalar()
    {
        return static::_isScalar();
    }
}
