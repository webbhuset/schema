Int
===

IntSchema validates integer values.


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

Set minimum value.


max
___

.. code-block:: php

    max ( int $max ) : self

Set maximum value.


.. include:: ../shared_functions.rst

Running :code:`validate()` with :code:`$strict = false` will do the following coercions:

- Floats are converted if the decimal value is 0 (e.g. :code:`1.0` would be converted to :code:`1`, while :code:`1.1` would not be converted).
- Strings are converted if they represent a valid integer, e.g. :code:`"123"`, :code:`"1e3"`, :code:`"-5"` are valid, while :code:`"123abc"`, :code:`"1.1"` are not.
- Bools are converted to :code:`1` when :code:`true` and :code:`0` when :code:`false`.
- :code:`null` is converted to :code:`0`.
- Other values are not converted.


Array Schema
------------

.. literalinclude:: /../src/IntSchema.php
    :language: php
    :lines: 54-61
    :dedent: 8


