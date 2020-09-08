<?php
declare(strict_types=1);

namespace Q\FP\Monad;

use ArrayAccess;
use Iterator;
use Q\FP\Monad;
use Q\FP\Functor;

use function Q\FP\map;

final class ListMonad implements Monad, Functor, Iterator, ArrayAccess {
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
        return $this->offsetExists($this->position);
    }

    public function offsetExists($offset) {
        return array_key_exists($offset, $this->value);
    }

    public function offsetGet($offset) {
        return $this->value[$offset] ?? null;
    }

    public function offsetSet($offset, $value) {
        throw new \Exception("You cannot change any value here, sorry");
    }

    public function offsetUnset($offset) {
        throw new \Exception("You cannot change any value here, sorry");
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

    public function extract() {
        return $this->value;
    }

    // fmap is Functor a -> (a -> b) -> Functor b
    public function fmap(callable $f): Functor {
        return new self(map($f)($this->value)());
    }
}
