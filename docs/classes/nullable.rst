==============
NullableSchema
==============

NullableSchema validates that a value either matches a specified schema or is :code:`null`.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\NullableSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( \Webbhuset\Schema\SchemaInterface $schema )
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

----

Methods
=======

.. _nullable-construct:

__construct
-----------

.. code-block:: php

    public __construct ( \Webbhuset\Schema\SchemaInterface $schema )

**Parameters**

:\\Webbhuset\\Schema\\SchemaInterface $schema: Schema to use for validation if value is not :code:`null`.

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

Normalizes a value. If the value is :code:`null` it is returned, otherwise it's passed to the schema provided in :ref:`nullable-construct`.

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the normalized value.

----

.. include:: ../shared_functions/validate.rst

----

Array Schema
============

.. literalinclude:: /../src/NullableSchema.php
    :language: php
    :lines: 28-33
    :dedent: 8

----

Examples
========

Example #1 NullableSchema usage example
---------------------------------------

.. literalinclude:: /../examples/nullable.php
    :language: php
