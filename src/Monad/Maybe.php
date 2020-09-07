<?php
declare(strict_types=1);

namespace Q\FP\Monad;

use Q\FP\Monad;
use Q\FP\Functor;

interface Maybe extends Monad, Functor {
    public function maybe($default, callable $f);
    public function isJust(): bool;
    public function isNothing(): bool;
    public function fromJust();
}
