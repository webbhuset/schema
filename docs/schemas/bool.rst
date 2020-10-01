Bool
====

BoolSchema validates bool values.


Functions
---------

__construct
___________

.. code-block:: php

    __construct ()


.. include:: ../shared_functions.rst

Running :code:`validate()` with :code:`$strict = false` will do conversion according to `PHP's rules for boolean casting`_.

.. _PHP's rules for boolean casting: https://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting


Array Schema
------------

.. literalinclude:: /../src/BoolSchema.php
    :language: php
    :lines: 20-23
    :dedent: 8
