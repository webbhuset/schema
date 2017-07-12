<?php

namespace Webbhuset\Data\Isomorphic;

interface IsomorphicFunctionInterface
{
    public function __invoke($value);
    public function flip();
}
