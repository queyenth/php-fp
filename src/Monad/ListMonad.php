<?php
declare(strict_types=1);

namespace Q\FP\Monad;

use Iterator;
use Q\FP\Monad;
use Q\FP\Functor;

use function Q\FP\map;

final class ListMonad implements Monad, Functor, Iterator {
    private array $value;
    private int $position = 0;

    public function __construct(array $value) {
        $this->value = $value;
    }

    public function current() {
        return $this->value[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next() {
        $this->position++;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid(): bool {
        return array_key_exists($this->position, $this->value);
    }

    // bind is Monad a -> (a -> Monad b) -> Monad b
    public function bind(callable $f): Monad {
        $newVal = [];
        foreach ($this->value as $x) {
            $ys = $f($x);
            foreach ($ys as $y) {
                $newVal[] = $y;
            }
        }

        return new self($newVal);
    }

    // fmap is Functor a -> (a -> b) -> Functor b
    public function fmap(callable $f): Functor {
        return new self(map($f)($this->value)());
    }
}
