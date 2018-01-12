<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class FloatType extends BaseFloatType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable   = $array['nullable'] ?? $this->isNullable;
        $this->min          = $array['min'] ?? $this->min;
        $this->max          = $array['max'] ?? $this->max;
    }
}
