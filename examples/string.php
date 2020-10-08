<?php

use Webbhuset\Schema\Constructor as S;

// Create a StringSchema.
$schema1 = S::String();


// Test with a valid value.
$data1 = 'foo';
$result1 = $schema1->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Test with an invalid value.
$data2 = true;
$result2 = $schema1->validate($data2);
var_dump($result2->isValid()); // bool(false)
var_dump($result2->getErrors());
/*
    array(1) {
      [0]=>
      string(23) "Value must be a string."
    }
*/


// Create a StringSchema with regex validation.
$schema2 = S::String()->regex('/cherr(y|ies)/', 'cherry or cherries');


// Test regex schema with a valid value.
$data3 = 'cherry';
$result3 = $schema2->validate($data3);
var_dump($result3->isValid()); // bool(true)


// Test regex schema with an invalid value.
$data4 = 'apples';
$result4 = $schema2->validate($data4);
var_dump($result4->isValid()); // bool(false)
var_dump($result4->getErrors());
/*
    array(1) {
      [0]=>
      string(53) "Value must match /cherr(y|ies)/ (cherry or cherries)."
    }
*/
