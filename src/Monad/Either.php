<?php
declare(strict_types=1);

namespace Q\FP\Monad;

use Q\FP\Monad;
use Q\FP\Functor;

interface Either extends Monad, Functor {
    public function either(callable $f, callable $g);
    public function isLeft(): bool;
    public function isRight(): bool;
    public function fromLeft($default);
    public function fromRight($default);
}
