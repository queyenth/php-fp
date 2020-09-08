<?php

namespace Q\FP\Monad\tests\units\Either;

use atoum;

class Left extends atoum {
    public function testBind() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->object($newTestInstance = $this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x * 2)))
            ->isInstanceOfTestedClass();

        $this
            ->given($newTestInstance)
            ->integer($newTestInstance->fromLeft('something'))
            ->isEqualTo(5);
    }

    public function testFmap() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->object($newTestInstance = $this->testedInstance->fmap(fn ($x) => $x * 2))
            ->isInstanceOfTestedClass();

        $this
            ->given($newTestInstance)
            ->integer($newTestInstance->fromLeft('something'))
            ->isEqualTo(5);
    }

    public function testEither() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->integer($this->testedInstance->either(fn ($x) => $x * 2, fn ($x) => $x * 3))
            ->isEqualTo(10);
    }

    public  function testIsLeft() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->boolean($this->testedInstance->isLeft())
            ->isTrue();
    }

    public function testIsRight() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->boolean($this->testedInstance->isRight())
            ->isFalse();
    }

    public function testFromLeft() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->integer($this->testedInstance->fromLeft('something'))
            ->isEqualTo(5);
    }

    public function testFromRight() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->string($this->testedInstance->fromRight('something'))
            ->isEqualTo('something');
    }

    public function testChain() {
        $classForTest = new class {
            private int $a = 5;
            public function getA() {
                return $this->a;
            }

            public function setA(int $a) {
                $this->a = 10;
                return $this;
            }
        };

        $this
            ->given($this->newTestedInstance($classForTest))
            ->then
            ->integer($this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x->setA(10)))->getA()->fromLeft('something')->getA())
            ->isEqualTo(5);

        $this
            ->given($this->newTestedInstance($classForTest))
            ->then
            ->object($this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x->setA(10)))->getB()->fromLeft('something'));
    }
}
