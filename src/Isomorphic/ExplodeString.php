<?php

namespace Webbhuset\Data\Isomorphic;

class ExplodeString implements IsomorphicFunctionInterface
{
    protected $delimiter;

    public function __construct($delimiter = ',')
    {
        $this->delimiter = $delimiter;
    }

    public function __invoke($value)
    {
        if ($value === null) {
            return [];
        }

        return explode($this->delimiter, $value);
    }

    public function flip()
    {
        return new ImplodeArray($this->delimiter);
    }
}
