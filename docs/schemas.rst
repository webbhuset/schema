List of Schema Types
====================

.. _simple-types:

Simple Types
------------

.. toctree::
    :hidden:
    :maxdepth: 1

    schemas/any
    schemas/bool
    schemas/float
    schemas/int
    schemas/string

* :doc:`/schemas/any` - Validates nothing (validation always succeeds).
* :doc:`/schemas/bool` - Validates that the input is a boolean.
* :doc:`/schemas/float` - Validates that the input is a float.
* :doc:`/schemas/int` - Validates that the input is an int.
* :doc:`/schemas/string` - Validates that the input is a string.


.. _composite-types:

Composite Types
---------------

.. toctree::
    :hidden:
    :maxdepth: 1

    schemas/dict
    schemas/one_of
    schemas/struct

* :doc:`/schemas/dict` - Validates that the input is an array with keys and values of specified schemas.
* :doc:`/schemas/one_of` - Validates that the input matches at least one of a list of schemas.
* :doc:`/schemas/struct` - Validates that the input is an array with specified fields.


.. _meta-types:

Meta Types
-------------

.. toctree::
    :hidden:
    :maxdepth: 1

    schemas/array_schema

* :doc:`/schemas/array_schema` - Validates that input is valid for fromArray.
