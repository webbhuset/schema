IntSchema
=========

IntSchema validates integer values.


Methods
-------

.. _int-construct:

__construct
___________

.. code-block:: php

    __construct ()


max
___

.. code-block:: php

    max ( int $max ) : self

Set maximum allowed value.

Parameters:

:$max: Maximum allowed value.


min
___

.. code-block:: php

    min ( int $min ) : self

Set minimum allowed value.

Parameters:

:$min: Minimum allowed value.


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
_________

.. code-block:: php

   normalize ( $value ) : mixed

Normalizes a value according to the following rules:

- Floats are converted to int if the decimal value is 0 (e.g. :code:`1.0` would be converted to :code:`1`, while :code:`1.1` would not be converted).
- Strings are converted to int if they represent a valid integer, e.g. :code:`"123"`, :code:`"1e3"`, :code:`"-5"` are valid, while :code:`"123abc"`, :code:`"1.1"` are not.
- Bools are converted to :code:`1` when :code:`true` or :code:`0` when :code:`false`.
- :code:`null` is converted to :code:`0`.
- Other values are not converted.

Parameters:

:$value: Value to normalize.


.. include:: ../shared_functions/validate.rst


Array Schema
------------

.. literalinclude:: /../src/IntSchema.php
    :language: php
    :lines: 56-62
    :dedent: 8
