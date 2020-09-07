<?php
declare(strict_types=1);

namespace Q\FP;

interface Functor {
    public function fmap(callable $f): Functor;
}
