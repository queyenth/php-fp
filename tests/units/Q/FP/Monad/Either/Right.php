<?php

namespace Q\FP\Monad\tests\units\Either;

use atoum;

class Right extends atoum {
    public function testBind() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->object($newTestInstance = $this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x * 2)))
            ->isInstanceOfTestedClass();

        $this
            ->given($newTestInstance)
            ->integer($newTestInstance->fromRight('something'))
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
            ->integer($newTestInstance->fromRight('something'))
            ->isEqualTo(10);
    }

    public function testEither() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->integer($this->testedInstance->either(fn ($x) => $x * 2, fn ($x) => $x * 3))
            ->isEqualTo(15);
    }

    public  function testIsLeft() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->boolean($this->testedInstance->isLeft())
            ->isFalse();
    }

    public  function testIsRight() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->boolean($this->testedInstance->isRight())
            ->isTrue();
    }

    public function testFromLeft() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->string($this->testedInstance->fromLeft('something'))
            ->isEqualTo('something');
    }

    public function testFromRight() {
        $this
            ->given($this->newTestedInstance(5))
            ->then
            ->integer($this->testedInstance->fromRight('something'))
            ->isEqualTo(5);
    }


    public function testChain() {
        $classForTest = new class {
            private int $a = 5;
            public function getA() {
                return $this->a;
            }

            public function setA(int $a) {
                $this->a = $a;
                return $this;
            }
        };

        $this
            ->given($this->newTestedInstance($classForTest))
            ->then
            ->integer($this->testedInstance->setA(10)->getA()->fromRight('something'))
            ->isEqualTo(10);

        $this
            ->given($this->newTestedInstance($classForTest))
            ->then
            ->exception(
                function () {
                    $this->testedInstance->bind(fn ($x) => $this->newTestedInstance($x->setA(10)))->getB();
                }
            );
    }
}
