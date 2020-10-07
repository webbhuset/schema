StringSchema
============

StringSchema validates string values.


Class synopsis
--------------

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


Methods
-------

.. _string-construct:

__construct
___________

.. code-block:: php

    public __construct ()


max
___

.. code-block:: php

    public max ( int $max ) : self

Set maximum string length.

Parameters:

:$min: Maximum allowed length.


min
___

.. code-block:: php

    public min ( int $min ) : self

Set minimum string length.

Parameters:

:$min: Minimum allowed length.


regex
_____

.. code-block:: php

    public regex ( string $regex [, ?string $description = '' ] ) : self

Set a regex the input must match. Optionally specify a description of the regex,
which will be included in the error message if the input doesn't match.

Parameters:

:$regex: Regex that must match.
:$description: Optional description.


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
_________

.. code-block:: php

   public normalize ( $value ) : mixed

Normalizes a value according to the following rules:

- Integers and floats are converted to their respective string representation.
- Bools are converted to :code:`"1"` when :code:`true` or :code:`"0"` when :code:`false`.
- :code:`null` is converted to :code:`""` (empty string).
- Other values are not converted.


.. include:: ../shared_functions/validate.rst


Array Schema
------------

.. literalinclude:: /../src/StringSchema.php
    :language: php
    :lines: 83-91
    :dedent: 8
