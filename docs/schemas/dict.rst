Dict
====

HashmapSchema validates collections of values with a specified key schema and value schema.


Constructor
-----------

.. code-block:: php

    __construct ( SchemaInterface $keySchema , SchemaInterface $valueSchema [, array $args = [] ] )

.. _keySchema:

:ref:`keySchema <keySchema>`
    Schema used for keys.

.. _valueSchema:

:ref:`valueSchema <valueSchema>`
    Schema used for values.

.. _args:

:ref:`args <args>`
    Optional arguments:

    .. _nullable:

    bool :ref:`NULLABLE <nullable>`
        Whether null values are allowed.
        Default value: :code:`false`.

    .. _min:

    int :ref:`MIN <min>`
        Minimum allowed amount of values.
        Default value: :code:`null`.

    .. _max:

    int :ref:`MAX <max>`
        Maximum allowed amount of values.
        Default value: :code:`null`.


Array Schema
------------

.. literalinclude:: /../src/DictSchema.php
    :language: php
    :lines: 74-83
    :dedent: 8


Casting
-------

The :code:`cast()` function will never attempt convert values.
