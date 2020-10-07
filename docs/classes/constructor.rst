Constructor
===========

Constructor is a utility class for constructing schema classes.

Class synopsis
--------------

.. code-block:: php

    \Webbhuset\Schema\Constructor {

        /* Methods */
        public static Any ( void ) : \Webbhuset\Schema\AnySchema
        public static ArraySchema ( void ) : \Webbhuset\Schema\ArraySchemaSchema
        public static Bool ( void ) : \Webbhuset\Schema\BoolSchema
        public static Dict ( \Webbhuset\Schema\SchemaInterface $keySchema , \Webbhuset\Schema\SchemaInterface $valueSchema ) : \Webbhuset\Schema\DictSchema
        public static Float ( void ) : \Webbhuset\Schema\FloatSchema
        public static Int ( void ) : \Webbhuset\Schema\IntSchema
        public static Nullable ( \Webbhuset\Schema\SchemaInterface $schema ) : \Webbhuset\Schema\NullableSchema
        public static OneOf ( array $schemas ) : \Webbhuset\Schema\OneOfSchema
        public static Struct ( array $fields ) : \Webbhuset\Schema\StructSchema
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( string $type ) : \Webbhuset\Schema\StructSchema
        public static validateArray ( \Webbhuset\Schema\StructSchema $schema , array $array ) : void
    }

Methods
-------

Any
___

.. code-block:: php

    public static Any ( void ) : \Webbhuset\Schema\AnySchema

Creates an :doc:`any`. See :ref:`AnySchema::__construct <any-construct>`.


ArraySchema
___________

.. code-block:: php

    public static ArraySchema ( void ) : \Webbhuset\Schema\ArraySchemaSchema

Creates an :doc:`array_schema`. See :ref:`ArraySchemaSchema::__construct <array-schema-construct>`.


Bool
____

.. code-block:: php

    public static Bool ( void ) : \Webbhuset\Schema\BoolSchema

Creates a :doc:`bool`. See :ref:`BoolSchema::__construct <bool-construct>`.


Dict
____

.. code-block:: php

    public static Dict ( \Webbhuset\Schema\SchemaInterface $keySchema , \Webbhuset\Schema\SchemaInterface $valueSchema ) : \Webbhuset\Schema\DictSchema

Creates a :doc:`dict`. See :ref:`DictSchema::__construct <dict-construct>`.


Float
_____

.. code-block:: php

    public static Float ( void ) : \Webbhuset\Schema\FloatSchema

Creates a :doc:`float`. See :ref:`FloatSchema::__construct <float-construct>`.


Int
___

.. code-block:: php

    public static Int ( void ) : \Webbhuset\Schema\IntSchema

Creates an :doc:`int`. See :ref:`IntSchema::__construct <int-construct>`.


Nullable
________

.. code-block:: php

    public static Nullable ( \Webbhuset\Schema\SchemaInterface $schema ) : \Webbhuset\Schema\NullableSchema

Creates a :doc:`nullable`. See :ref:`NullableSchema::__construct <nullable-construct>`.


OneOf
_____

.. code-block:: php

    public static OneOf ( array $schemas ) : \Webbhuset\Schema\OneOfSchema

Creates a :doc:`one_of`. See :ref:`OneOfSchema::__construct <one-of-construct>`.


String
______

.. code-block:: php

    public static String ( void ) : \Webbhuset\Schema\StringSchema

Creates a :doc:`string`. See :ref:`StringSchema::__construct <string-construct>`.


Struct
______

.. code-block:: php

    public static Struct ( array $fields ) : \Webbhuset\Schema\StructSchema

Creates a :doc:`struct`. See :ref:`StructSchema::__construct <struct-construct>`.


.. _fromArray:

fromArray
_________

.. code-block:: php

    public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface

Creates a schema from an array.

**Parameters**

:array $array: Array to build schema from.

**Return values**

Returns the built schema object.

**Throws**

:`InvalidArgumentException`_: When the provided array is invalid.


getArraySchema
______________

.. code-block:: php

    public static getArraySchema ( string $type ) : \Webbhuset\Schema\StructSchema

Returns an array schema for the provided type.

**Parameters**

:string $type: Name of the schema to get array schema for.

**Return values**

Returns a :doc:`/classes/struct`.

**Throws**

:`InvalidArgumentException`_: When the string provided in $type does not match a valid schema.


validateArray
_____________

.. code-block:: php

    public static validateArray ( \Webbhuset\Schema\StructSchema $schema , array $array ) : void

Validates that the provided array is valid for the provided schema.

**Parameters**

:\\Webbhuset\\Schema\\StructSchema $schema: The schema to use for validation.
:array $array: The array to validate.

**Return values**

No value is returned.

**Throws**

:`InvalidArgumentException`_: When the array provided in $array is invalid according to the schema provided in $schema..

.. _InvalidArgumentException: https://www.php.net/manual/en/class.invalidargumentexception.php
