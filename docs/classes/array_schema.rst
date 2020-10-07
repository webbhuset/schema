=================
ArraySchemaSchema
=================

ArraySchemaSchema validates that an array is valid for use with :ref:`fromArray`.


Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\StructSchema extends \Webbhuset\Schema\StructSchema {

        /* Methods */
        public __construct ( void )
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult

        /* Inherited methods */
        public StructSchema::normalize ( mixed $value ) : mixed
    }


Methods
=======

.. _array-schema-construct:

.. include:: ../shared_functions/construct.rst


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


.. include:: ../shared_functions/validate.rst


Array Schema
============

.. literalinclude:: /../src/ArraySchemaSchema.php
    :language: php
    :lines: 39-42
    :dedent: 8
