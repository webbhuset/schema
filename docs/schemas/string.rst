String
======

StringSchema validates string values.


Functions
---------

__construct
___________

.. code-block:: php

    __construct ()


min
___

.. code-block:: php

    min ( int $min ) : self

Set minimum string length.


max
___

.. code-block:: php

    max ( int $max ) : self

Set maximum string length.


regex
_____

.. code-block:: php

    regex ( string $regex [, ?string $description = '' ] ) : self

Set a regex the input must match. Optionally specify a description of the regex,
which will be included in the error message if the input doesn't match.

:regex: Regex that must match.
:description: Optional description.


.. include:: ../shared_functions.rst

Running :code:`validate()` with :code:`$strict = false` will do the following conversions:

- Integers and floats are converted to their respective string representation.
- Bools are converted to :code:`"1"` when :code:`true` and :code:`"0"` when :code:`false`.
- :code:`null` is converted to :code:`""` (empty string).
- Other values are not converted.


Array Schema
------------

.. literalinclude:: /../src/StringSchema.php
    :language: php
    :lines: 79-87
    :dedent: 8
