<?php

namespace Q\FP\Monad\tests\units\Maybe;

use atoum;

class Nothing extends atoum {
    public function testBind() {
        $this
            ->given($this->newTestedInstance)
            ->then
            ->object($newTestInstance = $this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x * 2)))
            ->isInstanceOfTestedClass();

        $this
            ->given($this->testedInstance)
            ->exception(
                function () {
                    $this->testedInstance->fromJust();
                }
            );
    }

    public function testFmap() {
        $this
            ->given($this->newTestedInstance)
            ->then
            ->object($newTestInstance = $this->testedInstance->fmap(fn ($x) => $x * 2))
            ->isInstanceOfTestedClass();
    }

    public function testMaybe() {
        $this
            ->given($this->newTestedInstance)
            ->then
            ->integer($this->testedInstance->maybe(5125, "Q\\FP\\id"))
            ->isEqualTo(5125);
    }

    public  function testIsJust() {
        $this
            ->given($this->newTestedInstance)
            ->then
            ->boolean($this->testedInstance->isJust())
            ->isFalse();
    }

    public  function testIsNothing() {
        $this
            ->given($this->newTestedInstance)
            ->then
            ->boolean($this->testedInstance->isNothing())
            ->isTrue();
    }

    public function testChain() {
        $this
            ->given($this->newTestedInstance)
            ->then
            ->object($this->testedInstance->getA())
            ->isInstanceOfTestedClass();
    }
}
