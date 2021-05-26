<?php
declare(strict_types=1);

namespace Q\FP;

function id ($x) {
    return $x;
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
