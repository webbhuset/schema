<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class StringType extends BaseStringType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable       = $array['nullable'] ?? $this->isNullable;
        $this->minLen           = $array['min'] ?? $this->minLen;
        $this->maxLen           = $array['max'] ?? $this->maxLen;
        $this->matches          = $array['matches'] ?? $this->matches;
        $this->notMatches       = $array['notMatches'] ?? $this->notMatches;
        $this->caseSensitive    = $array['caseSensitive'] ?? $this->caseSensitive;
    }
}
