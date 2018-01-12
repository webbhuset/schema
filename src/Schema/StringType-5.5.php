<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

class StringType extends BaseStringType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable       = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->minLen           = isset($array['min']) ? $array['min'] : $this->minLen;
        $this->maxLen           = isset($array['max']) ? $array['max'] : $this->maxLen;
        $this->matches          = isset($array['matches']) ? $array['matches'] : $this->matches;
        $this->notMatches       = isset($array['notMatches']) ? $array['notMatches'] : $this->notMatches;
        $this->caseSensitive    = isset($array['caseSensitive']) ? $array['caseSensitive'] : $this->caseSensitive;
    }
}
