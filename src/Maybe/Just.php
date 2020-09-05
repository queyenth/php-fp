<?php
declare(strict_types=1);

namespace Q\Monad\Maybe;

use Q\Monad\Maybe;
use Q\Monad\Monad;
use Q\Monad\Traits\ValueWrapper;

final class Just extends Maybe {
    use ValueWrapper;

    public function bind(callable $f): Monad {
        return Maybe::of($f($this->extract()));
    }

    public function maybe($default, callable $f) {
        return $f($this->extract());
    }

    public function isJust(): bool {
        return true;
    }

    public function isNothing(): bool {
        return false;
    }
}
