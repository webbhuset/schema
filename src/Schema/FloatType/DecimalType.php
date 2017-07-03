<?php
namespace Webbhuset\Data\Schema\FloatType;

use Webbhuset\Data\Schema;

class DecimalType extends Type\FloatType
{
    protected $tolerance = 1e-4;
    protected $decimalCount = 4;

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)){
            return $error;
        }

        if (is_null($value) && $this->isNullable) {
            return false;
        }

        $rounded = round($value, $this->decimalCount);
        if (abs($rounded - $value) > 1e-9) {
            return "Too many decimals, max {$this->decimalCount} allowed: {$value}";
        }

        return false;
    }
}
