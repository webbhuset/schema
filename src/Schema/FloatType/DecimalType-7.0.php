<?php

namespace Webbhuset\Data\Schema\FloatType;

use Webbhuset\Data\Schema\TypeConstructor as T;

class DecimalType extends BaseDecimalType
{
    protected function constructFromArray(array $array)
    {
        parent::constructFromArray($array);

        $this->decimalCount = $array['decimals'] ?? $this->decimalCount;
    }
}
