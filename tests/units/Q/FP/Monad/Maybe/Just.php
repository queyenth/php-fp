<?php

namespace Q\FP\Monad\tests\units\Maybe;

use atoum;

class Just extends atoum {
    public function testBind() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->object($newTestInstance = $this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x * 2)))
            ->isInstanceOfTestedClass();

        $this
            ->given($newTestInstance)
            ->integer($newTestInstance->fromJust())
            ->isEqualTo(10);
    }

    public function testFmap() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->object($newTestInstance = $this->testedInstance->fmap(fn ($x) => $x * 2))
            ->isInstanceOfTestedClass();

        $this
            ->given($newTestInstance)
            ->integer($newTestInstance->fromJust())
            ->isEqualTo(10);
    }

    public function testMaybe() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->integer($this->testedInstance->maybe(null, "Q\\FP\\id"))
            ->isEqualTo(5);
    }

    public  function testIsJust() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->boolean($this->testedInstance->isJust())
            ->isTrue();
    }

    public  function testIsNothing() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->boolean($this->testedInstance->isNothing())
            ->isFalse();
    }

    public function testChain() {
        $classForTest = new class {
            private int $a = 5;
            public function getA() {
                return $this->a;
            }
        };

        $this
            ->given($this->newTestedInstance($classForTest))
            ->then
            ->integer($this->testedInstance->getA()->fromJust())
            ->isEqualTo(5);

        $this
            ->given($this->newTestedInstance($classForTest))
            ->then
            ->exception(
                function () {
                    $this->testedInstance->getB()->fromJust();
                }
            );
    }
}
