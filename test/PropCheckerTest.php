<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\PropCheckFacade;
use Takemo101\SimplePropCheck\Exception\AbstractException;
use Takemo101\SimplePropCheck\Preset\NotEmpty;
use Takemo101\SimplePropCheck\Preset\String\{
    Pattern,
    LengthMin,
};

use DomainException;
use InvalidArgumentException;
use LogicException;
use Throwable;
use Attribute;

/**
 * prop checker test
 */
class PropCheckerTest extends TestCase
{
    /**
     * @test
     */
    public function createPropChecker__OK()
    {
        $checker = PropCheckFacade::factory(new TestObject(
            "aa",
            "b",
            "cc",
        ));
        $this->assertTrue($checker->check());
    }

    /**
     * @test
     */
    public function createPropChecker__domeinException__NG()
    {
        $this->expectException(DomainException::class);

        $checker = PropCheckFacade::factory(new TestObject(
            "aa",
            "b",
            "",
        ));
        $checker->checkWithException();
    }

    /**
     * @test
     */
    public function createPropChecker__invalidArgumentException__NG()
    {
        $this->expectException(InvalidArgumentException::class);

        $checker = PropCheckFacade::factory(new TestObject(
            "aa",
            "b",
            1,
        ));
        $checker->checkWithException();
    }

    /**
     * @test
     */
    public function createPropChecker__testException__NG()
    {
        $this->expectException(LogicException::class);

        $checker = PropCheckFacade::factory(new TestObject(
            "aa",
            "",
            "ccc",
        ));
        $checker->checkWithException();
    }

    /**
     * @test
     */
    public function createPropChecker__exceptionMessage__OK()
    {
        $checker = PropCheckFacade::factory(new TestObject(
            "ccd",
            "c",
            "ccc",
        ));
        try {
            $checker->checkWithException();
        } catch (LogicException $e) {
            $this->assertEquals('property logic error: not_match', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function createPropChecker__messageAnalyser__OK()
    {
        $checker = PropCheckFacade::factory(new TestObject(
            "aa",
            "c",
            "c",
        ));
        try {
            $checker->checkWithException();
        } catch (DomainException $e) {
            $this->assertEquals('property data error: [$c] not_match 1', $e->getMessage());
        }
    }
}

/**
 * test object class
 */
class TestObject
{
    #[NotEmpty]
    private static string $d = 'd';

    public function __construct(
        #[NotEmpty]
        #[Pattern('/aa/', 'not_match')]
        #[TestException]
        private string $a,
        #[NotEmpty]
        #[TestException]
        private string $b,
        #[NotEmpty]
        #[LengthMin(1, false, "[$:property] not_match :min")]
        public $c,
    ) {
        //
    }
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class TestException extends AbstractException
{
    /**
     * factory method
     *
     * @param string $message
     * @return Throwable
     */
    public function factory(string $message): Throwable
    {
        return new LogicException("property logic error: {$message}");
    }
}
