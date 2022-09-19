<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\PropCheckFacade;
use Takemo101\SimplePropCheck\Preset\Property\{
    LessThanOrEqual,
    GreaterThan,
    NotEquals,
};
use InvalidArgumentException;

/**
 * with properties test
 */
class WithPropertiesTest extends TestCase
{
    /**
     * @test
     */
    public function withProperties__OK()
    {
        $checker = PropCheckFacade::factory(new TestPropertyObject(
            'a',
            'b',
            10,
            9,
            12,
            12,
        ));
        $this->assertTrue($checker->check());
    }

    /**
     * @test
     */
    public function notFoundProperty__NG()
    {
        $this->expectException(InvalidArgumentException::class);

        $checker = PropCheckFacade::factory(new TestNotFoundPropertyObject(
            'a',
            'b',
        ));

        $checker->check();
    }
}

/**
 * test object class
 */
class TestPropertyObject
{
    public function __construct(
        #[NotEquals('b')]
        private string $a,
        private string $b,
        #[GreaterThan('d')]
        public int $c,
        public int $d,
        #[LessThanOrEqual('f')]
        public int $e,
        public int $f,
    ) {
        //
    }
}

/**
 * test object class
 */
class TestNotFoundPropertyObject
{
    public function __construct(
        #[NotEquals('c')]
        private string $a,
        private string $b,
    ) {
        //
    }
}
