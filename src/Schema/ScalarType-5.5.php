<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class ScalarType extends BaseScalarType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
    }
}
