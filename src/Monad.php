<?php
declare(strict_types=1);

namespace Q\Monad;

abstract class Monad {
    abstract public function bind(callable $f): Monad;
    abstract public function extract();

    public function match(array $matches) {
        foreach ($matches as $key => $f) {
            if ($key === static::class) {
                return $f($this->extract());
            }
        }
    }
}
