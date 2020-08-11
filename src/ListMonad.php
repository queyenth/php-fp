<?php
declare(strict_types=1);

namespace Q\Monad;

final class ListMonad extends Monad {
    private array $value;

    public function __construct(array $value) {
        $this->value = $value;
    }

    public static function of(array $value) {
        return new static($value);
    }

    public function bind(callable $f): Monad {
        return new static(
            $this->doValue(
                fn ($x) => $x->bind($f),
                fn ($x) => $f($x)
            )
        );
    }

    public function extract() {
        return $this->doValue(
            fn ($x) => $x->extract(),
            fn ($x) => $x
        );
    }

    protected function doValue(callable $doWithMonad, callable $doWithValue) {
        $res = [];

        foreach ($this->value as $item) {
            if ($item instanceof Monad) {
                $res[] = $doWithMonad($item);
            }
            else {
                $res[] = $doWithValue($item);
            }
        }

        return $res;
    }
}
