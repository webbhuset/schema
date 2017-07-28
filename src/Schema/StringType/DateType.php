<?php

namespace Webbhuset\Data\Schema\StringType;

use Webbhuset\Data\Schema\StringType;

class DateType extends StringType
{
    protected $matches = [
        '/^\d{4}-\d{2}-\d{2}$/' => 'Date is not in format "YYYY-MM-DD',
    ];
}
