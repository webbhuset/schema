<?php

namespace Webbhuset\Data\Isomorphic;

class MapValues implements IsomorphicFunctionInterface
{
    protected $map = [];
    protected $caseSensitive;

    public function __construct(array $map, $caseSensitive = true)
    {
        $this->caseSensitive = $caseSensitive;

        foreach ($map as $key => $value) {
            if (!$caseSensitive) {
                $key = mb_strtoupper($key);
            }
            $this->map[$key] = $value;
        }
    }

    public function __invoke($value)
    {
        if (is_array($value)) {
            foreach ($value as &$v) {
                $v = $this($v);
            }

            return $value;
        }

        $key = $this->caseSensitive ? $value : mb_strtoupper($value);

        return isset($this->map[$key]) ? $this->map[$key] : $value;
    }

    public function flip()
    {
        return new self(array_flip($this->map), $this->caseSensitive);
    }
}
