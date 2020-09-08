<?php

namespace Q\FP\Monad\tests\units;

use Q\FP\Monad\ListMonad as TestedListMonad;
use atoum;

class ListMonad extends atoum {
    public function testBind() {
        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->object($testInstance->bind(fn ($x) => new TestedListMonad([$x * 2])))
            ->isInstanceOf(TestedListMonad::class);

        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->array($testInstance->bind(fn ($x) => new TestedListMonad([$x * 2]))->extract())
            ->isEqualTo([2, 4, 6]);
    }

    public function testFmap() {
        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->object($testInstance->fmap(fn ($x) => $x * 2))
            ->isInstanceOf(TestedListMonad::class);

        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->array($testInstance->fmap(fn ($x) => $x * 2)->extract())
            ->isEqualTo([2, 4, 6]);
    }

    public function testIterator() {
        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->integer((function ($testInstance) {
                $sum = 0;
                foreach ($testInstance as $key => $elem) {
                    $sum += $elem;
                }

                return $sum;
            })($testInstance))
            ->isEqualTo(6);
    }

    public function testArrayAccess() {
        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->integer($testInstance[0])
            ->isEqualTo(1);

        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->variable($testInstance[4])
            ->isNull();

        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->variable($testInstance[4])
            ->isNull();

        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->exception(
                function () use ($testInstance) {
                    $testInstance[0] = 5;
                }
            );

        $this
            ->given($testInstance = new TestedListMonad([1, 2, 3]))
            ->then
            ->exception(
                function () use ($testInstance) {
                    unset($testInstance[0]);
                }
            );
    }
}
