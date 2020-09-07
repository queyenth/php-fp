<?php
declare(strict_types=1);

namespace Q\FP\Monad\Either;

use Q\FP\Functor;
use Q\FP\Monad;
use Q\FP\Monad\Either;
use Q\FP\Monad\Traits\Chain;

final class Right implements Either {
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

    public function either(callable $f, callable $g) {
        return $g($this->value);
    }

    public function isLeft(): bool {
        return false;
    }

    public function isRight(): bool {
        return true;
    }

    public function fromLeft($default) {
        return $default;
    }

    public function fromRight($default) {
        return $this->value;
    }
}
