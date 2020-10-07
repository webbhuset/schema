<?php

use Webbhuset\Schema\Constructor as S;

// Create a StructSchema.
$schema = S::Struct([
    'int' => S::Int(),
    'string' => S::String(),
]);


// Test with a valid value.
$data1 = [
    'int' => 2,
    'string' => 'Hello',
];
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with an invalid value.
$data2 = [
    'int' => '2',
    'float' => 5.0,
];
$result2 = $schema->validate($data2);
var_dump($result2->isValid()); // bool(false)
var_dump($result2->getErrors());
/*
    array(3) {
      ["int"]=>
      array(1) {
        [0]=>
        string(21) "Value must be an int."
      }
      ["string"]=>
      array(1) {
        [0]=>
        string(18) "Value must be set."
      }
      ["float"]=>
      array(1) {
        [0]=>
        string(30) "Undefined key must not be set."
      }
    }
*/


// Test normalize.
$data3 = $schema->normalize($data2);
var_dump($data3);
/*
    array(2) {
      ["int"]=>
      int(2)
      ["string"]=>
      string(0) ""
    }
*/
$result3 = $schema->validate($data3);
var_dump($result3->isValid()); // bool(true)
