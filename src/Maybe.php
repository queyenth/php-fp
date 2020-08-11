<?php
declare(strict_types=1);

namespace Q\Monad;

use Q\Monad\Maybe\Just;
use Q\Monad\Maybe\Nothing;

abstract class Maybe extends Monad {
    public static function of($value): Maybe {
        if ($value instanceof Maybe) {
            return $value;
        }

        if ($value === null) {
            return new Nothing();
        }

        return new Just($value);
    }

    public function __call($funcName, $args) {
        return $this->bind(function ($value) use ($funcName, $args) {
            $callableFunc = array($value, $funcName);
            return (is_callable($callableFunc) ? call_user_func_array($callableFunc, $args) : null);
        });
    }

    abstract public function maybe($default, callable $f);
}
