<?php

use Webbhuset\Schema\Constructor as S;

// Create a OneOfSchema.
$schema = S::OneOf([
    S::Int(),
    S::String(),
]);


// Test with a valid value.
$data1 = 1;
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with an invalid value.
$data2 = 1.0;
$result2 = $schema->validate($data2);
var_dump($result2->isValid()); // bool(false)
var_dump($result2->getErrors());
/*
    array(1) {
      ["Value must match one of the following:"]=>
      array(2) {
        [0]=>
        array(1) {
          [0]=>
          string(21) "Value must be an int."
        }
        [1]=>
        array(1) {
          [0]=>
          string(23) "Value must be a string."
        }
      }
    }
*/
