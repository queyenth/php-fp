<?php
declare(strict_types=1);

namespace Q\Monad;

use Q\Monad\Monad;
use Q\Monad\Traits\ValueWrapper;

abstract class Either extends Monad {
    use ValueWrapper;

    public static function of($value) {
        if ($value instanceof Monad) {
            return new static($value->extract());
        }

        return new static($value);
    }
}
