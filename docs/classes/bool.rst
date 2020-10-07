==========
BoolSchema
==========

BoolSchema validates that a value is a bool.


Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\BoolSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( void )
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }


Methods
=======

.. _bool-construct:

.. include:: ../shared_functions/construct.rst


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
---------

.. code-block:: php

   public normalize ( mixed $value ) : mixed

Normalized a value. Values are converted according to `PHP's rules for boolean casting`_.

.. _PHP's rules for boolean casting: https://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the normalized value.


.. include:: ../shared_functions/validate.rst


Array Schema
============

.. literalinclude:: /../src/BoolSchema.php
    :language: php
    :lines: 20-23
    :dedent: 8


Examples
========

Example #1 BoolSchema usage example
-------------------------------------

.. literalinclude:: /../examples/bool.php
    :language: php
