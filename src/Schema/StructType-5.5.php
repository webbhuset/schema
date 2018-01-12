<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class StructType extends BaseStructType
{
    protected function constructFromArray(array $array)
    {
        $fields = [];
        foreach ($array['fields'] as $key => $fieldArray) {
            $fields[$key] = T::constructFromArray($fieldArray);
        }

        $this->isNullable   = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->fields       = $fields;
    }
}
