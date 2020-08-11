<?php
declare(strict_types=1);

namespace Q\Monad\Either;

use Q\Monad\Either;
use Q\Monad\Monad;

final class Left extends Either {
    public function bind(callable $f): Monad {
        return $this;
    }
}
