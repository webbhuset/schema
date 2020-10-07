AnySchema
=========

AnySchema doesn't do any validation and accepts anything as valid.


Class synopsis
--------------

.. code-block:: php

    \Webbhuset\Schema\AnySchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( void )
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

Methods
-------

.. _any-construct:

.. include:: ../shared_functions/construct.rst


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
_________

.. code-block:: php

   public normalize ( mixed $value ) : mixed

Returns in the input value.

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the input value.


.. include:: ../shared_functions/validate.rst


Array Schema
------------

.. literalinclude:: /../src/AnySchema.php
    :language: php
    :lines: 20-23
    :dedent: 8


Examples
--------

Example #1 AnySchema usage example
__________________________________

.. literalinclude:: /../examples/any.php
    :language: php
