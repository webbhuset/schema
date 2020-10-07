<?php

use Webbhuset\Schema\Constructor as S;


// Create a StringSchema.
$schema1 = S::String();
var_dump(get_class($schema1)); // string(29) "Webbhuset\Schema\StringSchema"


// Create schema from an array.
$array = [
    'type' => 'int',
    'args' => [
        'max' => null,
        'min' => null,
    ],
];
$schema2 = S::fromArray($array);
var_dump(get_class($schema2)); // string(26) "Webbhuset\Schema\IntSchema"
