Dict
====

DictSchema validates arrays with a specified key schema and value schema.


Functions
---------

__construct
___________

.. code-block:: php

    __construct ( SchemaInterface $keySchema , SchemaInterface $valueSchema )


min
___

.. code-block:: php

    min ( int $min ) : self

Set minimum allowed items.


max
___

.. code-block:: php

    max ( int $max ) : self

Set maximum allowed items.


.. include:: ../shared_functions.rst


Array Schema
------------

.. literalinclude:: /../src/DictSchema.php
    :language: php
    :lines: 69-77
    :dedent: 8
