=========
IntSchema
=========

IntSchema validates integer values.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\IntSchema implements \Webbhuset\Schema\SchemaInterface {

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

.. _int-construct:

.. include:: ../shared_functions/construct.rst

----

max
---

.. code-block:: php

    public max ( int $max ) : self

Set maximum allowed value.

**Parameters**

:int $max: Maximum allowed values.

**Return values**

Returns a copy of self with maximum value set.

**Throws**

:`InvalidArgumentException`_: When the provided $max is higher than the current min.

----

min
---

.. code-block:: php

    public min ( int $min ) : self

Set minimum allowed value.

**Parameters**

:float $min: Minimum allowed value.

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

   public normalize ( value $value ) : mixed

Normalizes a value according to the following rules:

- Floats are converted to int if the decimal value is 0 (e.g. :code:`1.0` would be converted to :code:`1`, while :code:`1.1` would not be converted).
- Strings are converted to int if they represent a valid integer, e.g. :code:`"123"`, :code:`"1e3"`, :code:`"-5"` are valid, while :code:`"123abc"`, :code:`"1.1"` are not.
- Bools are converted to :code:`1` when :code:`true` or :code:`0` when :code:`false`.
- :code:`null` is converted to :code:`0`.
- Other values are not converted.

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the normalized value.

----

.. include:: ../shared_functions/validate.rst

----

Array Schema
============

.. literalinclude:: /../src/IntSchema.php
    :language: php
    :lines: 60-66
    :dedent: 8

----

Examples
========

Example #1 DictSchema usage example
-----------------------------------

.. literalinclude:: /../examples/int.php
    :language: php
