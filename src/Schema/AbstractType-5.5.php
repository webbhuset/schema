<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

abstract class AbstractType implements TypeInterface
{
    protected $isNullable = false;

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

    abstract protected function constructFromArray(array $array);

    protected function afterConstruct()
    {

    }

    protected function parseArg($arg)
    {
        if ($arg == T::NULLABLE) {
            $this->isNullable = true;
        }
    }

    public function getErrors($value)
    {
        if (is_null($value) && !$this->isNullable) {
            return "Value is required";
        }

        return false;
    }

    public function isEqual($a, $b)
    {
        return $a == $b;
    }

    public function cast($value)
    {
        return $value;
    }

    /**
     * Returns the string representation of a value.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function getValueString($value)
    {
        if (is_object($value)) {
            return 'Object';
        }
        if (is_array($value)) {
            return 'Array';
        }

        return (string) $value;
    }

    public function diff($a, $b)
    {
        throw new TypeException("Diff method not implemented for this type.");
    }

    public function isScalar()
    {
        return false;
    }
}
