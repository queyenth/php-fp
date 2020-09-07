<?php
declare(strict_types=1);

namespace Q\FP\Monad\Either;

use Q\FP\Functor;
use Q\FP\Monad;
use Q\FP\Monad\Either;
use Q\FP\Monad\Traits\Chain;

final class Left implements Either {
    use Chain;

    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function bind(callable $f): Monad {
        return $this;
    }

    public function fmap(callable $f): Functor {
        return $this;
    }

    public function either(callable $f, callable $g) {
        return $f($this->value);
    }

    public function isLeft(): bool {
        return true;
    }

    public function isRight(): bool {
        return false;
    }

    public function fromLeft($default) {
        return $this->value;
    }

    public function fromRight($default) {
        return $default;
    }
}
