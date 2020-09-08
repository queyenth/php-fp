<?php
declare(strict_types=1);

namespace Q\FP\Monad\Maybe;

use Q\FP\Functor;
use Q\FP\Monad;
use Q\FP\Monad\Maybe;
use Q\FP\Monad\Traits\Chain;

final class Just implements Maybe {
    use Chain;

    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function bind(callable $f): Monad {
        return $f($this->value);
    }

    public function fmap(callable $f): Functor {
        return new self($f($this->value));
    }

    public function maybe($default, callable $f) {
        return $f($this->value);
    }

    public function isJust(): bool {
        return true;
    }

    public function isNothing(): bool {
        return false;
    }

    public function fromJust() {
        return $this->value;
    }
}
