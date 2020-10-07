<?php

use Webbhuset\Schema\Constructor as S;

// Create an AnySchema.
$schema = S::Any();


// Validate int.
$data1 = 1;
$result1 = $schema->validate($data1);
var_dump($result1->isValid()); // bool(true)


// Validate null.
$data2 = null;
$result2 = $schema->validate($data1);
var_dump($result2->isValid()); // bool(true)


// Validate array.
$data3 = [1, 2, 3];
$result3 = $schema->validate($data1);
var_dump($result3->isValid()); // bool(true)
