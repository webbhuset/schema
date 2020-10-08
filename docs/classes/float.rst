===========
FloatSchema
===========

FloatSchema validates that a value is a float.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\FloatSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( void )
        public max ( float $max ) : self
        public min ( float $min ) : self
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

----

Methods
=======

.. _float-construct:

.. include:: ../shared_functions/construct.rst

----

max
---

.. code-block:: php

    public max ( float $max ) : self

Set maximum allowed value.

**Parameters**

:float $max: Maximum allowed values.

**Return values**

Returns a copy of self with maximum value set.

**Throws**

:`InvalidArgumentException`_: When the provided $max is higher than the current min.

----

min
---

.. code-block:: php

    public min ( float $min ) : self

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

   public normalize ( mixed $value ) : mixed

Normalizes a value according to the following rules:

- Integers are converted to floats.
- Strings are converted to floats if they represent a valid float, e.g. :code:`"123"`, :code:`"1e3"`, :code:`"-5.2"` are valid, while :code:`"123abc"`, :code:`"1.1.0"` are not.
- Bools are converted to :code:`1.0` when :code:`true` or :code:`0.0` when :code:`false`.
- :code:`null` is converted to :code:`0.0`.
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

.. literalinclude:: /../src/FloatSchema.php
    :language: php
    :lines: 56-62
    :dedent: 8

----

Examples
========

Example #1 DictSchema usage example
-----------------------------------

.. literalinclude:: /../examples/float.php
    :language: php
