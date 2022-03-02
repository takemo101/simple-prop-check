<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\PropCheckerFactory;
use Takemo101\SimplePropCheck\Preset\NotEmpty;

use DomainException;

/**
 * prop checker test
 */
class PropCheckerFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function factoryCheck()
    {
        $this->assertTrue(PropCheckerFactory::check(new FactoryTestObject(
            "",
            "b",
        )));
        $this->assertFalse(PropCheckerFactory::check(new FactoryTestObject(
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

        PropCheckerFactory::exception(new FactoryTestObject(
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
