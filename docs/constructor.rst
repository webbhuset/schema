Constructor
===========


Parameters
----------

.. _nullable:

:ref:`NULLABLE <nullable>`
    .. code-block:: php

        const NULLABLE
        function NULLABLE ( bool $value ) : ?string

    Used by: All

    Allow null values.


.. _skip_empty:

:ref:`SKIP_EMPTY <skip_empty>`
    .. code-block:: php

        const SKIP_EMPTY
        function SKIP_EMPTY ( bool $value ) : ?string

    Used by:
    :doc:`/schemas/hashmap`

    Skip empty values.


.. _allow_undefined:

:ref:`ALLOW_UNDEFINED <allow_undefined>`
    .. code-block:: php

        const ALLOW_UNDEFINED
        function ALLOW_UNDEFINED ( bool $value ) : ?string

    Used by:
    :doc:`/schemas/hashmap`

    Allow undefined values.


.. _min:

:ref:`MIN <min>`
    .. code-block:: php

        function MIN ( bool $value ) : array

    Used by:
    :doc:`/schemas/float`,
    :doc:`/schemas/hashmap`,
    :doc:`/schemas/int`,
    :doc:`/schemas/set`,
    :doc:`/schemas/string`

    Minimum value allowed.


.. _max:

:ref:`MAX <max>`
    .. code-block:: php

        function MAX ( bool $value ) : array

    Used by:
    :doc:`/schemas/float`,
    :doc:`/schemas/hashmap`,
    :doc:`/schemas/int`,
    :doc:`/schemas/set`,
    :doc:`/schemas/string`

    Maximum value allowed.


.. _case_sensitive:

:ref:`CASE_SENSITIVE <case_sensitive>`
    .. code-block:: php

        const CASE_SENSITIVE
        const CASE_INSENSITIVE
        function CASE_SENSITIVE ( bool $value ) : string

    Used by:
    :doc:`/schemas/enum`

    Values are case sensitive.
