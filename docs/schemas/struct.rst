Struct
======

StructSchema validates collections of values with specific keys and schemas.


Functions
---------

__construct
___________

.. code-block:: php

    __construct ( array $fields [, array $args = [] ] )


errorOnMissing
______________

.. code-block:: php

    errorOnMissing () : self

TODO


missingAsNull
_____________

.. code-block:: php

    missingAsNull () : self

TODO


skipMissing
___________

.. code-block:: php

    skipMissing () : self

TODO


allowUndefined
______________

.. code-block:: php

    allowUndefined ( bool $allow ) : self

TODO


.. include:: ../shared_functions.rst


Array Schema
------------

.. literalinclude:: /../src/StructSchema.php
    :language: php
    :lines: 87-106
    :dedent: 8
