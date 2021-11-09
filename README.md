# Dhii - Pipe
[![Continuous Integration](https://github.com/Dhii/pipe/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/Dhii/pipe/actions/workflows/continuous-integration.yml)

A universal piping mechanism.

## Details
This package aims to provide some common denominator in terms of abstract pipe concepts and dispatching
functionality.

## Rationale
A common pattern in handling HTTP requests is by using HTTP middleware - such as any [PSR-15][]
pipe implementation. This is very useful and convenient, because there can be any number of
middlewares between the request and response, and each middleware can choose how to handle the
value and whether to pass it on to other middleware - while still guaranteeing an adequate result.

This is not only useful in dealing with HTTP, however, as the pattern is much more generic than that:
simply take a value, pass it through an arbitrary number of "handlers", and retrieve the result.
A non-HTTP example of what could be standardized this way is event dispatching, like [PSR-14][]
implementations: an event is being passed through an arbitrary series of handlers to produce
a result (a possibly modified event, in this case).

In fact, any functional scenario can be
represented in this way, and albeit it isn't always practical or semantically correct to
implement a solution as middleware (or a pipe thereof): specific problems require specific
solutions with specific interfaces. However, there are many generic scenarios where an abstract
pipe dispatcher would be helpful. Such a dispatcher can be specialized for the task, and easily
be grafted into existing functionality to make it more configurable and implementation-agnostic -
which is what often happens with "events" or "hooks" in many frameworks. Yet, such hooks are a
subset of middleware, and not the other way around.


[PSR-15]: https://www.php-fig.org/psr/psr-15/
[PSR-14]: https://www.php-fig.org/psr/psr-14/
