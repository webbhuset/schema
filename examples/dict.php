<?php

use Webbhuset\Schema\Constructor as S;


// Create a DictSchema.
$schema = S::Dict(S::Int(), S::String());


// Test with a valid value.
$data1 = [
    'foo',
    'bar'
];
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with an invalid value.
$data2 = [
    0 => 0,
    'foo' => 'bar',
];
$result2 = $schema->validate($data2);
var_dump($result2->isValid()); // bool(false)
var_dump($result2->getErrors());
/*
    array(2) {
      [0]=>
      array(1) {
        ["value"]=>
        array(1) {
          [0]=>
          string(23) "Value must be a string."
        }
      }
      ["foo"]=>
      array(1) {
        ["key"]=>
        array(1) {
          [0]=>
          string(21) "Value must be an int."
        }
      }
    }
*/
