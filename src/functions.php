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

function comp(...$fns) {
	return array_reduce(
		$fns,
		function (callable $f, callable $g) : callable {
			return function (...$args) use ($f, $g) {
				return $f(call_user_func_array($g, $args));
			};
		},
		'id'
	);
}
