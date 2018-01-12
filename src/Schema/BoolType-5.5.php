<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class BoolType extends BaseBoolType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
    }
}
