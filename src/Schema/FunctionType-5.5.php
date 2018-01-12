<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class FunctionType extends FunctionType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
    }
}
