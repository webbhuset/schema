===========
OneOfSchema
===========

OneOfSchema validates that values matches one of a list of specified schemas.


Methods
=======

.. _one-of-construct:

__construct
-----------

.. code-block:: php

    __construct ( array $schemas )


.. include:: ../shared_functions/from_array.rst


.. include:: ../shared_functions/get_array_schema.rst


.. include:: ../shared_functions/to_array.rst


normalize
---------

.. code-block:: php

   normalize ( $value ) : mixed


.. include:: ../shared_functions/validate.rst


Array Schema
============

.. literalinclude:: /../src/OneOfSchema.php
    :language: php
    :lines: 45-50
    :dedent: 8
