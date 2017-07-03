<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class UnionType extends AbstractType
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

    protected function constructFromArray(array $array)
    {
        $types = [];
        foreach ($array['types'] as $typeArray) {
            $types = T::constructFromArray($typeArray);
        }

        $this->types = $types;
    }

    public function toArray() : array
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

    public static function getArraySchema() : TypeInterface
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
            return "Value is not of any type in the union";
        }

        return false;
    }

    public function isEqual($a, $b) : bool
    {
    }

    public function cast($value)
    {
    }

    public function isScalar() : bool
    {
        foreach ($this->types as $type) {
            if (!$type->isScalar()) {
                return false;
            }
        }

        return true;
    }
}
