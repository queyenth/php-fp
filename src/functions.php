<?php
declare(strict_types=1);

namespace Q\FP;

use ReflectionFunction;

function id ($x) {
    return $x;
}

// Not recursive clean stuff
function map(callable $f, ...$args) : callable {
    return call_user_func_array('Q\\FP\\curry', ['array_map', $f, ...$args]);
}

function curry(callable $f, ...$args) : callable {
    return function () use ($f, $args) {
        $reflect = new ReflectionFunction($f);
        $reqCount = $reflect->getNumberOfRequiredParameters();

        // If we passed something, then we should apply it
        $funcArgs = func_get_args();
        if (count($funcArgs)) {
            return curry(
                $f,
                // Sooo... we destruct both arrays with args and also destruct them then we pass it to curry!
                ...[...$args, ...func_get_args()]
            );
        }

        if (count($args) >= $reqCount) {
            return call_user_func_array($f, $args);
        }
    };
}
