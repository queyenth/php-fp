<?php
declare(strict_types=1);

namespace Q\Monad\Traits;

use Q\Monad\Monad;

trait ValueWrapper {
    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function extract() {
        if ($this->value instanceof Monad) {
            return $this->value->extract();
        }

        return $this->value;
    }
}
