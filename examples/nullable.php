<?php

use Webbhuset\Schema\Constructor as S;

// Create a NullableSchema.
$schema = S::Nullable(S::Int());


// Test with null.
$data1 = null;
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with a valid value.
$data2 = 1;
$result2 = $schema->validate($data2);
var_dump($result2->isValid()); // bool(true)


// Test with an invalid value.
$data3 = '1';
$result3 = $schema->validate($data3);
var_dump($result3->isValid()); // bool(false)
var_dump($result3->getErrors());
/*
    array(1) {
      ["Value must be null or match the following:"]=>
      array(1) {
        [0]=>
        string(21) "Value must be an int."
      }
    }
*/
