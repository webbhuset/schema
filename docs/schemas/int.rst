Int
===

1 2 3


Constructor
-----------

.. code-block:: php

    __construct ( [ array $args = [] ] )

.. _args:

:ref:`args <args>`
    Optional arguments:

    .. _nullable:

    bool :ref:`NULLABLE <nullable>`
        Whether null values are allowed. Default value: :code:`false`.

    .. _min:

    int :ref:`MIN <min>`
        Minimum allowed value. Default value: :code:`null`.

    .. _max:

    int :ref:`MAX <max>`
        Maximum allowed value. Default value: :code:`null`.


Array Schema
------------

.. literalinclude:: /../src/Simple/IntSchema.php
    :language: php
    :lines: 54-61
    :dedent: 8


Casting
-------

The :code:`cast()` function will attempt to convert values to an integer.

- Floats are converted if the decimal value is 0, e.g. 1.0 would be converted to 1, while 1.1 would not be converted.
- Strings are converted if they represent a valid integer, e.g. "123", "1e3", "-5" are valid, while "123abc", "1.1" are not.
- Bools are converted to 1 and 0 for true and false, respectively.
- Null is converted to 0 if :ref:`NULLABLE <nullable>` is false, otherwise left as null.
- Other values are not converted.
