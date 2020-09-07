<?php
declare(strict_types=1);

namespace Q\FP\Monad\Maybe;

use Q\FP\Functor;
use Q\FP\Monad;
use Q\FP\Monad\Maybe;
use Q\FP\Monad\Traits\Chain;

final class Nothing implements Maybe {
    use Chain;

    public function bind(callable $f): Monad {
        return $this;
    }

    public function fmap(callable $f): Functor {
        return $this;
    }

    public function maybe($default, callable $f) {
        return $default;
    }

    public function isJust(): bool {
        return false;
    }

    public function isNothing(): bool {
        return true;
    }

    public function fromJust() {
        throw new \Exception("You cannot do fromJust on Nothing!");
    }
}
