<?php
declare(strict_types=1);

namespace Q\FP;

use Q\FP\Monad\Maybe;

function id ($x) {
    return $x;
}

function maybe($value): Maybe {
    if (is_null($value)) {
        return new Maybe\Nothing;
    }

    return new Maybe\Just($value);
}

function partial(callable $fn, ...$args): callable {
    return function (...$newArgs) use ($fn, $args) {
        return $fn(...[...$args, ...$newArgs]);
    };
}

function comp(...$fns) {
    $fn = array_pop($fns);
	return array_reduce(
		array_reverse($fns),
		function (callable $f, callable $g) : callable {
			return function (...$args) use ($f, $g) {
				return $f($g(...$args));
			};
		},
        $fn
	);
}

// Meaning partialy apply $fn, by returning new function that waits
// for first argument. Not really curry, but yeah.
function curry_first(callable $fn, ...$curryArgs): callable {
    return function ($arg) use ($fn, $curryArgs) {
        return $fn(...[$arg, ...$curryArgs]);
    };
}

// Meaning partialy apply $fn, by returning new function that waits
// for last argument. Not really curry, but yeah.
function curry_last(callable $fn, ...$curryArgs): callable {
    return function ($arg) use ($fn, $curryArgs) {
        return $fn(...[...$curryArgs, $arg]);
    };
}

function thread__internal(callable $curryFn, ...$exprs) {
    return array_reduce(
        $exprs,
        function ($result, $expr) use ($curryFn) {
            if (is_callable($expr)) {
                $result = $expr($result);
            } else if (is_array($expr)) {
                $func = array_shift($expr);
                if (is_callable($func)) {
                    $result = $curryFn($func, ...$expr)($result);
                } else {
                    $result = [$func, ...$expr];
                }
            } else {
                $result = $expr;
            }

            return $result;
        },
        null
    );
}

function thread_first(...$exprs) {
    return thread__internal('curry_first', ...$exprs);
}

function thread_last(...$exprs) {
    return thread__internal('curry_last', ...$exprs);
}

function reduce(callable $fn, $initial, iterable $input) {
    foreach ($input as $x) {
        $initial = $fn($initial, $x);
    }

    return $initial;
}

function mapping(callable $fn): callable {
    return function (callable $stepFn) use ($fn) {
        return function ($result, $x) use ($fn, $stepFn) {
            return $stepFn($result, $fn($x));
        };
    };
}

function filtering(callable $fn): callable {
    return function (callable $stepFn) use ($fn) {
        return function ($result, $x) use ($fn, $stepFn) {
            if ($fn($x)) {
                return $stepFn($result, $x);
            }

            return $result;
        };
    };
}
