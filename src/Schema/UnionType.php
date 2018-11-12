<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseUnionType extends AbstractType
{
    protected $types = [];


    protected function parseArg($arg)
    {
        if ($arg instanceof TypeInterface) {
            $this->types[] = $arg;
            return;
        }

        parent::parseArg($arg);
    }

    protected function afterConstruct()
    {
        if (empty($this->types)) {
            throw new TypeException("Union must have at least one type.");
        }
    }

    protected function constructFromArray(array $array)
    {
        foreach ($array['types'] as $typeArray) {
            $this->types[] = T::constructFromArray($typeArray);
        }
    }

    protected function _toArray()
    {
        $types = [];
        foreach ($this->types as $type) {
            $types[] = $type->toArray();
        }

        return [
            'type'  => 'union',
            'args'  => [
                'types' => $types,
            ]
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['union']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'types'     => T::Set(T::ArraySchema()),
            ])
        ]);
    }

    public function getErrors($value)
    {
        $oneTypeMatches = false;

        foreach ($this->types as $type) {
            $errors = $type->getErrors($value);

            if ($errors === false) {
                $oneTypeMatches = true;

                break;
            }
        }

        if (!$oneTypeMatches) {
            return "Value is not of any type in the union.";
        }

        return false;
    }

    public function cast($value)
    {
        throw new TypeException("Cannot cast to a union type.");
    }

    protected function _isScalar()
    {
        foreach ($this->types as $type) {
            if (!$type->isScalar()) {
                return false;
            }
        }

        return true;
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'UnionType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'UnionType-5.5.php';
}
