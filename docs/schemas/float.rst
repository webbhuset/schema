Float
=====

FloatSchema validates float values.


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

Set minimum allowed value.


max
___

.. code-block:: php

    max ( int $max ) : self

Set maximum allowed value.


.. include:: ../shared_functions.rst

Running :code:`validate()` with :code:`$strict = false` will do the following coercions:

- Integers are converted to floats.
- Strings are converted if they represent a valid float, e.g. :code:`"123"`, :code:`"1e3"`, :code:`"-5.2"` are valid, while :code:`"123abc"`, :code:`"1.1.0"` are not.
- Bools are converted to :code:`1.0` when :code:`true` and :code:`0.0` when :code:`false`.
- :code:`null` is converted to :code:`0.0`.
- Other values are not converted.


Array Schema
------------

.. literalinclude:: /../src/FloatSchema.php
    :language: php
    :lines: 56-62
    :dedent: 8
