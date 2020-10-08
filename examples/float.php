<?php


use Webbhuset\Schema\Constructor as S;

// Create a FloatSchema.
$schema = S::Float();


// Test with a valid value.
$data1 = 1.5;
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with an invalid value.
$data2 = 1;
$result2 = $schema->validate($data2);
var_dump($result2->isValid()); // bool(false)
var_dump($result2->getErrors());
/*
    array(1) {
      [0]=>
      string(22) "Value must be a float."
    }
*/
