<?php

namespace Webbhuset\Data\Isomorphic;

class WrapValue implements IsomorphicFunctionInterface
{
    public function __invoke($value)
    {
        $value = [$value];

        return $value;
    }

    public function flip()
    {
        return new ExtractValue();
    }
}

