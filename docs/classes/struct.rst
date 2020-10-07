StructSchema
============

StructSchema validates that an array have specific keys and and that the value of each key matches another schema.


Class synopsis
--------------

.. code-block:: php

    \Webbhuset\Schema\StructSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( array $fields )
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

Methods
-------

.. _struct-construct:

__construct
___________

.. code-block:: php

    public __construct ( array $fields )

**Parameters**

:array $fields: Array of fields. Each value in the array must implement :doc:`/classes/schema_interface`.

**Throws**

:`InvalidArgumentException`_: When any value in $fields does not implement :doc:`/classes/schema_interface`.

.. _InvalidArgumentException: https://www.php.net/manual/en/class.invalidargumentexception.php


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
_________

.. code-block:: php

   public normalize ( mixed $value ) : mixed

Normalizes a value. The following steps are done in order:

1. If the input value is not an array or null, the input is value is returned.
2. For each defined key, run normalize with its schema. If no value is set for the key in the input, :code:`null` is passed instead.
3. Any undefined keys are unset.

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the normalized value.


.. include:: ../shared_functions/validate.rst


Array Schema
------------

.. literalinclude:: /../src/StructSchema.php
    :language: php
    :lines: 39-52
    :dedent: 8


Examples
--------

Example #1 StructSchema usage example
_____________________________________

.. literalinclude:: /../examples/struct.php
    :language: php
