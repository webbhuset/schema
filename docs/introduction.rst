============
Introduction
============

Schema is a PHP library for normalizing and validating data. When working with PHP chances are
you'll find yourself with arrays of data that you want to make sure contains specific keys and/or
values. An example is if you are parsing a JSON, and want to validate it:


.. code-block:: php

    <?php

    use Webbhuset\Schema\Constructor as S;

    function createUserFromFile(string $path): User
    {
        // Create a schema.
        $schema = S::Struct([
            'id' => S::Int()->min(0),
            'name' => S::String(),
            'nickname' => S::Nullable(S::String()),
            'phoneNumbers' => S::Dict(S::Int(), S::String()),
        ]);

        // Read file contents.
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        // Normalize the data. This ensures keys are present in the array, and performs safe typecasting.
        $data = $schema->normalize($data);

        // Validate the normalized data.
        $result = $schema->validate($data);

        // Check if data is valid.
        if ($result->isValid()) {
            // We can safely pass array values to the following constructor:
            // __construct(int $id, string $name, ?string $nickname, array $phoneNumbers)
            return new User($data['id'], $data['name'], $data['nickname'], $data['phoneNumbers']);
        } else {
            // Throw exception if data is invalid.
            throw new \InvalidArgumentException("Invalid data:\n{$result->getErrorsAsString()}");
        }
    }


Installation
============

You can install Pipeline with `Composer`_ by by running ``composer require webbhuset/schema`` in your terminal or by manually adding ``"webbhuset/schena": "*"`` to your composer.json and running ``composer update webbhuset/schema``.

.. _Composer: https://getcomposer.org/


Getting started
===============

Once the library is installed you can start using it. The easiest way to create schemas is by using
the :doc:`/classes/constructor` utility class (but creating schemas directly with ``new`` is of
course still an option.). Check out :doc:`/classes/schema_interface` to get an idea of the base
functionality of a schema is, and then check :ref:`schema-classes` for a list of available schemas.
