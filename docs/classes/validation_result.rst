================
ValidationResult
================

Data class returned by validation functions.

----

Class synopsis
==============

.. code-block:: php

    \Webbhuset\Schema\ValidationResult {

        /* Methods /*
        public __construct( array $errors = [] )
        public isValid ( void ) : bool
        public getErrors ( void ) : array
        public getErrorsAsString ( void ) : string
    }

----

Methods
=======

__construct
-----------

.. code-block:: php

    public __construct( array $errors = [] )

**Parameters**

:$errors: Array of errors.

----

isValid
-------

.. code-block:: php

    public isValid ( void ) : bool

Check if result is valid.

**Parameters**

This method has no parameters.

**Return values**

Returns :code:`true` if no errors were provided in the constructor, otherwise :code:`false`.

----

getErrors
---------

.. code-block:: php

    public getErrors ( void ) : array

Returns errors.

**Parameters**

This method has no parameters.

**Return values**

Returns the errors provided in the constructor.

----

getErrorsAsString
-----------------

.. code-block:: php

    public getErrorsAsString ( void ) : string

Returns errors as a string.

**Parameters**

This method has no parameters.

**Return values**

Returns the errors provided in the constructor formatted as a pretty-printed JSON.
