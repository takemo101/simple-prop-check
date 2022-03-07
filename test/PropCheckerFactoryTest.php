<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\PropCheckFacade;
use Takemo101\SimplePropCheck\Preset\NotEmpty;

use DomainException;

/**
 * prop checker test
 */
class PropCheckFacadeTest extends TestCase
{
    /**
     * @test
     */
    public function factoryCheck()
    {
        $this->assertTrue(PropCheckFacade::check(new FactoryTestObject(
            "",
            "b",
        )));
        $this->assertFalse(PropCheckFacade::check(new FactoryTestObject(
            "",
            "",
        )));
    }

    /**
     * @test
     */
    public function factoryException()
    {
        $this->expectException(DomainException::class);

        PropCheckFacade::exception(new FactoryTestObject(
            "",
            "",
        ));
    }
}

/**
 * factory test object class
 */
class FactoryTestObject
{
    public function __construct(
        private string $b,
        #[NotEmpty]
        public string $c,
    ) {
        //
    }
}
