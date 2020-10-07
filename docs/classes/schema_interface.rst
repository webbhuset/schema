SchemaInterface
===============

Interface for all schema classes.


Class synopsis
--------------

.. code-block:: php

    \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        abstract public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        abstract public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        abstract public toArray ( void ) : array
        abstract public normalize ( mixed $value ) : mixed
        abstract public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }


Methods
-------

fromArray
_________

.. code-block:: php

    abstract public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface

Build schema from an array.

**Parameters**

:$array: Array to build schema from.

**Return values**

Returns the built schema object.


getArraySchema
______________

.. code-block:: php

    abstract public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema

Returns a schema that can validate the array used by fromArray and returned by toArray.

**Parameters**

This method has no parameters.

**Return values**

Returns a :doc:`/classes/struct`.


toArray
_______

.. code-block:: php

    abstract public toArray ( void ) : array

Serialize the schema as an array.

**Parameters**

This method has no parameters.

**Return values**

Returns the schema as a serialized array.


normalize
_________

.. code-block:: php

    abstract public normalize ( mixed $value ) : mixed

Normalize a value.

**Parameters**

:$value: The value to normalize.

**Return values**

Returns the normalized value.


validate
________

.. code-block:: php

    abstract public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult

Validate a value.

**Parameters**

:$value: The value to validate.

**Return values**

Returns a :doc:`/classes/validation_result`.
