<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class EnumType extends BaseEnumType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable       = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->values           = $array['values'];
        $this->caseSensitive    = isset($array['caseSensitive']) ? $array['caseSensitive'] : $this->caseSensitive;
    }
}
