# PHP Built-in Exception Types (Hierarchy Overview) 🧐

The exception system in modern PHP (PHP 7+) is rooted in the **`Throwable`** interface, which is implemented by two main branches: **`Error`** (for fatal internal issues) and **`Exception`** (for recoverable program errors).

***

## 1. The Error Branch (Internal/Fatal Problems)

These indicate problems that should typically stop execution and are not intended to be caught routinely, but can be caught using `catch (\Error $e)`.

| Error Class | Purpose (What it Signifies) |
| :--- | :--- |
| **`TypeError`** | Invalid argument or return value type received. |
| **`ArgumentCountError`** | Too few arguments passed to a function/method. |
| **`ParseError`** | Invalid syntax encountered (e.g., during `eval()`). |
| **`ArithmeticError`** | Error during mathematical operation (e.g., invalid bitshift). |
| **`DivisionByZeroError`** | Attempting to divide a number by zero. |
| **`AssertionError`** | An `assert()` statement failed. |

***

## 2. The Exception Branch (Program Logic/Runtime Problems)

These are the primary types for standard application exceptions, typically extending the base **`\Exception`** class or its SPL subclasses.

### A. Logic Exceptions (`LogicException`)

Indicate faults in the program's logic that should be fixed before deployment.

| Logic Exception | Purpose (What it Signifies) |
| :--- | :--- |
| **`InvalidArgumentException`** | A function argument is the correct type but an incorrect value. |
| **`BadMethodCallException`** | Attempted to call a non-existent method. |
| **`BadFunctionCallException`** | Attempted to call a non-existent function. |
| **`DomainException`** | A value is outside the legal domain of values defined by a method. |
| **`LengthException`** | Length (e.g., of a string or array) is invalid. |
| **`OutOfRangeException`** | A generated value or index is out of its valid range. |

### B. Runtime Exceptions (`RuntimeException`)

Indicate errors that occur during the execution and are difficult to prevent through code-time logic checks.

| Runtime Exception | Purpose (What it Signifies) |
| :--- | :--- |
| **`OutOfBoundsException`** | An invalid index (key) was requested (e.g., in an array or container). |
| **`OverflowException`** | Adding an element to a container that is full. |
| **`UnderflowException`** | Performing an invalid operation on an empty container. |
| **`UnexpectedValueException`** | A method returned an unexpected value type. |
| **`RangeException`** | An internal arithmetic error occurred. |

### C. Other Common Exceptions

| Specific Exception | Purpose (What it Signifies) |
| :--- | :--- |
| **`ErrorException`** | Used by PHP's error handler to convert a standard PHP error into a catchable exception. |
| **`JsonException`** (PHP 7.3+) | Error during JSON encoding or decoding. |
| **`PDOException`** | Error during database operations using PDO. |
| **`ReflectionException`** | Error during reflection operations. |