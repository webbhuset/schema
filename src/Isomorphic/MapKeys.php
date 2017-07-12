<?php

namespace Webbhuset\Data\Isomorphic;

use Webbhuset\Data\Schema;
use Webbhuset\Data\Schema\TypeConstructor as T;

class MapKeys implements IsomorphicFunctionInterface
{
    protected $map;
    protected $children;
    protected $wildcard;
    protected $default;

    public function __construct(
        array $map,
        $default        = null,
        array $children = [],
        $wildcard       = '*'
    ) {
        $mapType = T::Hashmap(
            T::Scalar(),
            T::Union(T::Scalar(), T::Set(T::Scalar()))
        );

        $errors = $mapType->getErrors($map);

        if ($errors) {
            throw new Schema\TypeException("Constructor param map is not key values.", null, null, $errors);
        }

        foreach ($children as $child) {
            if (!$child instanceof IsomorphicFunctionInterface) {
                throw new \InvalidArgumentException('Children must implement IsomorphicMapperInterface.');
            }
        }

        $this->map          = $map;
        $this->children     = $children;
        $this->wildcard     = $wildcard;
        $this->default      = $default;
    }

    public function __invoke($array, $filter = false, $overwrite = false)
    {
        if (!is_array($array)) {
            if ($this->default === null) {
                return $array;
            }

            if (array_key_exists($this->default, $this->children)) {
                $childFunc  = $this->children[$this->default];
                $value      = $childFunc($array);
            } else {
                $value = $array;
            }
            return [$this->default => $value];
        }

        $newArray = [];

        foreach ($array as $key => $value) {
            if (array_key_exists($key, $this->children)) {
                $childFunc  = $this->children[$key];
                $value      = $childFunc($value);
            } elseif (array_key_exists($this->wildcard, $this->children)) {
                $childFunc  = $this->children[$this->wildcard];
                $value      = $childFunc($value);
            }

            if (!array_key_exists($key, $this->map)) {
                $array[$key] = $value;
                continue;
            }


            $newKeys = $this->map[$key];
            if (is_array($newKeys)) {
                foreach ($newKeys as $newKey) {
                    $newArray[$newKey] = $value;
                }
            } else {
                $newArray[$newKeys] = $value;
            }
            unset($array[$key]);
        }

        if ($filter) {
            return $newArray;
        }

        if ($overwrite) {
            return array_replace($array, $newArray);
        } else {
            return array_replace($newArray, $array);
        }
    }

    public function flip()
    {
        $children = [];
        $default = null;

        foreach ($this->children as $key => $child) {
            if (array_key_exists($key, $this->map)) {
                $key = $this->map[$key];
            }

            $children[$key] = $child->flip();
        }


        $map = [];
        foreach ($this->map as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    if (isset($map[$v])) {
                        if (!is_array($map[$v])) {
                            $map[$v] = [$map[$v]];
                        }
                        $map[$v][] = $key;
                    } else {
                        $map[$v] = $key;
                    }
                }
            } else {
                if (isset($map[$value])) {
                    if (!is_array($map[$value])) {
                        $map[$value] = [$map[$value]];
                    }
                    $map[$value][] = $key;
                } else {
                    $map[$value] = $key;
                }
            }
        }

        if ($this->default !== null && array_key_exists($this->default, $map)) {
            $default = $map[$this->default];
        }

        return new self($map, $default, $children, $this->wildcard);
    }

    public function addChildren($children, $wildcard = '*')
    {
        return new self($this->map, $this->default, $children, $wildcard);
    }
}
