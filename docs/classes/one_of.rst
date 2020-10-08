===========
OneOfSchema
===========

OneOfSchema validates that a value matches at least one of a list of specified schemas.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\OneOfSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( array $schemas )
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

----

Methods
=======

.. _one-of-construct:

__construct
-----------

.. code-block:: php

    public __construct ( array $schemas )

**Parameters**

:array $fields: Array of schemas. Each value in the array must implement :doc:`/classes/schema_interface`.

**Throws**

:`InvalidArgumentException`_: When $schemas is empty or any value in $schemas does not implement :doc:`/classes/schema_interface`.

.. _InvalidArgumentException: https://www.php.net/manual/en/class.invalidargumentexception.php

----

.. include:: ../shared_functions/from_array.rst

----

.. include:: ../shared_functions/get_array_schema.rst

----

.. include:: ../shared_functions/to_array.rst

----

normalize
---------

.. code-block:: php

   public normalize ( mixed $value ) : mixed

Returns the input value.

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the input value.

----

.. include:: ../shared_functions/validate.rst

----

Array Schema
============

.. literalinclude:: /../src/OneOfSchema.php
    :language: php
    :lines: 45-50
    :dedent: 8

----

Examples
========

Example #1 OneOfSchema usage example
------------------------------------

.. literalinclude:: /../examples/one-of.php
    :language: php
