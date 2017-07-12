<?php

namespace Webbhuset\Data\Isomorphic;

class ExtractValue implements IsomorphicFunctionInterface
{
    public function __invoke($value)
    {
        if (!is_array($value)) {
            return $value;
        }

        $value = reset($value);

        return $value;
    }

    public function flip()
    {
        return new WrapValue();
    }
}
