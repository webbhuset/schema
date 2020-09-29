fromArray
_________

.. code-block:: php

    fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface

Build schema from a serialized array.


getArraySchema
______________

.. code-block:: php

   getArraySchema () : \Webbhuset\Schema\StructSchema

Get a StructSchema of the schema used by :code:`fromArray()` and :code:`toArray()`.


toArray
_______

.. code-block:: php

   toArray () : array

Convert schema into a serialized array.


validate
________

.. code-block:: php

   validate ( $value [, bool $strict = true ] )

Validates a value.
