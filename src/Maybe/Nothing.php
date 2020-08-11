<?php
declare(strict_types=1);

namespace Q\Monad\Maybe;

use Q\Monad\Maybe;
use Q\Monad\Monad;

final class Nothing extends Maybe {
    public function bind(callable $f): Monad {
        return $this;
    }

    public function extract() {
        return null;
    }

    public function maybe($default, callable $f) {
        return $default;
    }
}
