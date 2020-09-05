<?php
declare(strict_types=1);

namespace Q\Monad;

use Q\Monad\Maybe\Just;
use Q\Monad\Maybe\Nothing;

use Q\Monad\Traits\Chain;

abstract class Maybe extends Monad {
    use Chain;

    public static function of($value): Maybe {
        if ($value instanceof Maybe) {
            return $value;
        }

        if ($value === null) {
            return new Nothing();
        }

        return new Just($value);
    }

    abstract public function maybe($default, callable $f);
    abstract public function isJust(): bool;
    abstract public function isNothing(): bool;
    abstract public function fromJust();
}
