Struct
======

StructSchema validates collections of values with specific keys and schemas.

Constructor
-----------

.. code-block:: php

    __construct ( array $fields [, array $args = [] ] )

.. _fields:

:ref:`fields <fields>`
    Array of fields, with the key representing the field name and the value the field schema.

.. _args:

:ref:`args <args>`
    Optional arguments:

    .. _nullable:

    bool :ref:`NULLABLE <nullable>`
        Whether null values are allowed.
        Default value: ``false``.

    .. _missing:

    string :ref:`MISSING <missing>`
        How to handle missing keys.
        Default value: ``ERROR_ON_MISSING``.

        ERROR_ON_MISSING:
            Missing keys are treated as errors.

        SKIP_MISSING:
            Missing keys are ignored.

        MISSING_AS_NULL:
            Missing keys are treated as ``null``.

    .. _allow_undefined:

    bool :ref:`ALLOW_UNDEFINED <allow_undefined>`
        Whether keys not defined in :ref:`fields <fields>` are allowed.
        If false, errors are returned for undefined keys.
        Default value: ``true``.


Array Schema
------------

.. literalinclude:: /../src/StructSchema.php
    :language: php
    :lines: 60-72
    :dedent: 8
