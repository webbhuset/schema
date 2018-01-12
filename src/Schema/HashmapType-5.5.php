<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class HashmapType extends BaseHashmapType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable   = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->min          = isset($array['min']) ? $array['min'] : $this->min;
        $this->max          = isset($array['max']) ? $array['max'] : $this->max;
        $this->keyType      = T::constructFromArray($array['key']);
        $this->valueType    = T::constructFromArray($array['value']);
    }
}
