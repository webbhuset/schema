<?php

namespace Webbhuset\Data\Schema\StringType;

use Webbhuset\Data\Schema\StringType;
use Webbhuset\Data\Schema\TypeConstructor as T;

class DateType extends StringType
{
    protected $matches = [
        '/^\d{4}-\d{2}-\d{2}$/' => 'Date is not in format "YYYY-MM-DD',
    ];


    protected function _toArray()
    {
        return [
            'type'  => 'date',
            'args'  => [
                'nullable'      => $this->isNullable,
            ],
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['date']),
            'args' => T::Struct([
                'nullable'      => T::Bool(T::NULLABLE),
            ])
        ]);
    }
}
