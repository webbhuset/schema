==========
DictSchema
==========

DictSchema validates that a value is an arrays with each key matching a specified schema and each value another schema.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\DictSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( void )
        public max ( int $max ) : self
        public min ( int $min ) : self
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

----

Methods
=======

.. _dict-construct:

__construct
-----------

.. code-block:: php

    public __construct ( \Webbhuset\Schema\SchemaInterface $keySchema , \Webbhuset\Schema\SchemaInterface $valueSchema )

**Parameters**

:\\Webbhuset\\Schema\\SchemaInterface $keySchema: Schema to use for key validation.
:\\Webbhuset\\Schema\\SchemaInterface $valueSchema: Schema to use for value validation.

----

max
---

.. code-block:: php

    public max ( int $max ) : self

Set maximum number of allowed items in array.

**Parameters**

:int $max: Maximum number of values.

**Return values**

Returns a copy of self with maximum value set.

**Throws**

:`InvalidArgumentException`_: When the provided $max is higher than the current min.

----

min
---

.. code-block:: php

    public min ( int $min ) : self

Set minimum number of allowed items in array.

**Parameters**

:int $min: Minimum number of values.

**Return values**

Returns a copy of self with minimum value set.

**Throws**

:`InvalidArgumentException`_: When the provided $min is lower than the current max.

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

Normalizes a value. Each key and value is passed to the normalize function of the key schema and value schema, respectively. An input of :code:`null` is normalized to :code:`[]` (empty array).

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the normalized value.

----

.. include:: ../shared_functions/validate.rst

----

Array Schema
============

.. literalinclude:: /../src/DictSchema.php
    :language: php
    :lines: 69-77
    :dedent: 8

----

Examples
========

Example #1 DictSchema usage example
-----------------------------------

.. literalinclude:: /../examples/dict.php
    :language: php
