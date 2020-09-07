<?php
declare(strict_types=1);

namespace Q\FP;

interface Monad {
    public function bind(callable $f): Monad;
}
