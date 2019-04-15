String
======

StringSchema validates string values.


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
        Minimum allowed length. Default value: :code:`null`.

    .. _max:

    int :ref:`MAX <max>`
        Maximum allowed length. Default value: :code:`null`.

    .. _matches:

    array :ref:`MATCHES <matches>`
        Regex patterns that values must match. Default value :code:`[]`.


Array Schema
------------

.. literalinclude:: /../src/Simple/StringSchema.php
    :language: php
    :lines: 64-72
    :dedent: 8


Casting
-------

The :code:`cast()` function will attempt to convert values to a string.

- Integers and floats are converted to their respective string representation.
- Bools are converted to "1" and "0" for true and false, respectively.
- Null is converted to "" (empty string) if :ref:`NULLABLE <nullable>` is false, otherwise left as null.
- Other values are not converted.
