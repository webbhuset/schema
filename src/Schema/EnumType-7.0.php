<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class EnumType extends BaseEnumType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable       = $array['nullable'] ?? $this->isNullable;
        $this->values           = $array['values'];
        $this->caseSensitive    = $array['caseSensitive'] ?? $this->caseSensitive;
    }
}
