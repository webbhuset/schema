<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class SetType extends BaseSetType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable   = $array['nullable'] ?? $this->isNullable;
        $this->min          = $array['min'] ?? $this->min;
        $this->max          = $array['max'] ?? $this->max;
        $this->type         = T::constructFromArray($array['type']);
    }
}
