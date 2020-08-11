<?php
declare(strict_types=1);

namespace Q\Monad\Traits;

trait Chain {
    public function __call($funcName, $args) {
        return $this->bind(function ($value) use ($funcName, $args) {
            $callableFunc = array($value, $funcName);
            return (is_callable($callableFunc) ? call_user_func_array($callableFunc, $args) : null);
        });
    }
}
