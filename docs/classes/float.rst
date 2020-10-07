===========
FloatSchema
===========

FloatSchema validates float values.


Methods
=======

.. _float-construct:

__construct
-----------

.. code-block:: php

    __construct ()


max
---

.. code-block:: php

    max ( float $max ) : self

Set maximum allowed value.

Parameters:

:$max: Maximum allowed value.


min
---

.. code-block:: php

    min ( float $min ) : self

Set minimum allowed value.

Parameters:

:$min: Maximum allowed value.


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
---------

.. code-block:: php

   normalize ( $value ) : mixed

Normalizes a value according to the following rules:

- Integers are converted to floats.
- Strings are converted to floats if they represent a valid float, e.g. :code:`"123"`, :code:`"1e3"`, :code:`"-5.2"` are valid, while :code:`"123abc"`, :code:`"1.1.0"` are not.
- Bools are converted to :code:`1.0` when :code:`true` or :code:`0.0` when :code:`false`.
- :code:`null` is converted to :code:`0.0`.
- Other values are not converted.


.. include:: ../shared_functions/validate.rst


Array Schema
============

.. literalinclude:: /../src/FloatSchema.php
    :language: php
    :lines: 56-62
    :dedent: 8
