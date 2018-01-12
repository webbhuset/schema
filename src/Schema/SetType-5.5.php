<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class SetType extends BaseSetType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable   = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->min          = isset($array['min']) ? $array['min'] : $this->min;
        $this->max          = isset($array['max']) ? $array['max'] : $this->max;
        $this->type         = T::constructFromArray($array['type']);
    }
}
