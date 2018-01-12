<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseAnyType extends AbstractType
{
    protected function _toArray()
    {
        return [
            'type'  => 'any',
            'args'  => [
                'nullable'      => $this->isNullable,
            ],
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['any']),
            'args' => T::Struct([
                'nullable' => T::Bool(T::NULLABLE),
            ])
        ]);
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'AnyType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'AnyType-5.5.php';
}
