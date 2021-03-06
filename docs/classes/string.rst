============
StringSchema
============

StringSchema validates string values.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\StringSchema implements \Webbhuset\Schema\SchemaInterface {

        /* Methods */
        public __construct ( void )
        public max ( int $max ) : self
        public min ( int $min ) : self
        public regex ( string $regex[, ?string $description = '' ] ) : self
        public static fromArray ( array $array ) : \Webbhuset\Schema\SchemaInterface
        public static getArraySchema ( void ) : \Webbhuset\Schema\StructSchema
        public toArray ( void ) : array
        public normalize ( mixed $value ) : mixed
        public validate ( mixed $value ) : \Webbhuset\Schema\ValidationResult
    }

----

Methods
=======

.. _string-construct:

.. include:: ../shared_functions/construct.rst

----

max
---

.. code-block:: php

    public max ( int $max ) : self

Set maximum string length.

**Parameters**

:int $min: Maximum allowed length.

**Return values**

Returns a copy of self with maximum length set.

**Throws**

:`InvalidArgumentException`_: When the provided $max is higher than the current min.

----

min
---

.. code-block:: php

    public min ( int $min ) : self

Set minimum string length.

**Parameters**

:int $min: Minimum allowed length.

**Return values**

Returns a copy of self with minimum length set.

**Throws**

:`InvalidArgumentException`_: When the provided $min is lower than the current max.

----

regex
-----

.. code-block:: php

    public regex ( string $regex [, ?string $description = '' ] ) : self

Set a regex the input must match. Optionally specify a description of the regex,
which will be included in the error message if the input doesn't match.

**Parameters**

:string $regex: Regex that must match.
:?string $description: Optional description.

**Return values**

Returns a copy of self with regex set.

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

- Integers and floats are converted to their respective string representation.
- Bools are converted to :code:`"1"` when :code:`true` or :code:`"0"` when :code:`false`.
- :code:`null` is converted to :code:`""` (empty string).
- Other values are not converted.

**Parameters**

:mixed $value: The value to normalize.

**Return values**

Returns the input value.

----

.. include:: ../shared_functions/validate.rst

----

Array Schema
============

.. literalinclude:: /../src/StringSchema.php
    :language: php
    :lines: 83-91
    :dedent: 8

----

Examples
========

Example #1 StringSchema usage example
-------------------------------------

.. literalinclude:: /../examples/string.php
    :language: php
