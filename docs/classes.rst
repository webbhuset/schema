=======
Classes
=======

General classes
===============

.. toctree::
    :hidden:
    :maxdepth: 1

    classes/constructor
    classes/validation_result
    classes/schema_interface

* :doc:`/classes/constructor` - Utility class for constructing schema classes.
* :doc:`/classes/validation_result` - Data class returned by validation functions.
* :doc:`/classes/schema_interface` - Interface implemented by schema classes.


Schema classes
==============

.. toctree::
    :hidden:
    :maxdepth: 1

    classes/any
    classes/array_schema
    classes/bool
    classes/dict
    classes/float
    classes/int
    classes/nullable
    classes/one_of
    classes/string
    classes/struct

* :doc:`/classes/any` - Validates anything (i.e. validation always succeeds).
* :doc:`/classes/array_schema` - Validates that input is valid for :ref:`fromArray`.
* :doc:`/classes/bool` - Validates that the input is a boolean.
* :doc:`/classes/dict` - Validates that the input is an array with keys and values of specified schemas.
* :doc:`/classes/float` - Validates that the input is a float.
* :doc:`/classes/int` - Validates that the input is an int.
* :doc:`/classes/nullable` - Validates that the input either matches a specified schema or is null.
* :doc:`/classes/one_of` - Validates that the input matches at least one of a list of schemas.
* :doc:`/classes/string` - Validates that the input is a string.
* :doc:`/classes/struct` - Validates that the input is an array with specified fields.
