<?php

use Webbhuset\Schema\Constructor as S;

// Create a IntSchema.
$schema = S::Int();


// Test with a valid value.
$data1 = 1;
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with an invalid value.
$data2 = '1';
$result2 = $schema->validate($data2);
var_dump($result2->isValid()); // bool(false)
var_dump($result2->getErrors());
/*
    array(1) {
      [0]=>
      string(21) "Value must be an int."
    }
*/
