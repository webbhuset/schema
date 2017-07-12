<?php

namespace Webbhuset\Data\Isomorphic;

class ImplodeArray implements IsomorphicFunctionInterface
{
    protected $delimiter;

    public function __construct($delimiter = ',')
    {
        $this->delimiter = $delimiter;
    }

    public function __invoke($value)
    {
        return implode($this->delimiter, $value);
    }

    public function flip()
    {
        return new ExplodeString($this->delimiter);
    }
}
