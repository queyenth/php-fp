<?php
declare(strict_types=1);

namespace Q\Monad\Either;

use Q\Monad\Either;
use Q\Monad\Monad;

final class Right extends Either {
    public static function of($value) {
        if ($value instanceof Left) {
            return $value;
        }

        return parent::of($value);
    }

    public function bind(callable $f): Monad {
        return Right::of($f($this->extract()));
    }
}
