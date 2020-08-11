<?php
declare(strict_types=1);

namespace Q\Monad;

use Q\Monad\Monad;
use Q\Monad\Traits\ValueWrapper;
use Q\Monad\Traits\Chain;

abstract class Either extends Monad {
    use ValueWrapper;
    use Chain;

    public static function of($value) {
        if ($value instanceof Monad) {
            return new static($value->extract());
        }

        return new static($value);
    }
}
