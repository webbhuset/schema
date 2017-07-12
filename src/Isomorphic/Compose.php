<?php

namespace Webbhuset\Data\Isomorphic;

class Compose implements IsomorphicFunctionInterface
{
    protected $functions;

    public function __construct(array $functions)
    {
        foreach ($functions as $function) {
            if (!$function instanceof IsomorphicfunctionInterface) {
                // TODO: Replace with is_callable + reflection checking the function
                throw new \InvalidArgumentException('Functions must implement IsomorphicFunctionInterface.');
            }
        }

        $this->functions = $functions;
    }

    public function __invoke($value)
    {
        foreach ($this->functions as $function) {
            $value = $function($value);
        }

        return $value;
    }

    public function flip()
    {
        $flippedFunctions = [];

        foreach (array_reverse($this->functions) as $function) {
            $flippedFunctions[] = $function->flip();
        }

        return new self($flippedFunctions);
    }
}
