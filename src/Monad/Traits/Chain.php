<?php
declare(strict_types=1);

namespace Q\FP\Monad\Traits;

trait Chain {
    public function __call($funcName, $args) {
        return $this->bind(function ($value) use ($funcName, $args) {
            $callableFunc = array($value, $funcName);
            if (is_callable($callableFunc)) {
                return call_user_func_array($callableFunc, $args);
            }

            throw new \BadFunctionCallException("$funcName does not exist!");
        });
    }
}
