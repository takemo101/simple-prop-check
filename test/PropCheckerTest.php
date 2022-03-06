<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\{
    PropCheckFacade,
    Effect,
    AfterCall,
};
use Takemo101\SimplePropCheck\Exception\AbstractException;
use Takemo101\SimplePropCheck\Preset\NotEmpty;
use Takemo101\SimplePropCheck\Preset\Numeric\Max;
use Takemo101\SimplePropCheck\Preset\String\{
    Pattern,
    MinLength,
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
        $checker->exception();
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
        $checker->exception();
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
        $checker->exception();
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
            $checker->exception();
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
            $checker->exception();
        } catch (DomainException $e) {
            $this->assertEquals('property data error: [Test\TestObject::$c] not_match 1', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function createPropChecker__effect__OK()
    {
        $checker = PropCheckFacade::factory(new FirstObject(
            "aa",
            new SecondObject(
                'a',
                new ThirdObject(
                    'a',
                    1,
                ),
            ),
            [],
        ));

        $this->assertTrue($checker->check());
    }

    /**
     * @test
     */
    public function createPropChecker__effect__NG()
    {
        $this->expectException(LogicException::class);

        PropCheckFacade::exception(new FirstObject(
            "aa",
            new SecondObject(
                'a',
                new ThirdObject(
                    'a',
                    1,
                ),
            ),
            [
                new ThirdObject(
                    'a',
                    1,
                ),
                new ThirdObject(
                    'a',
                    1,
                ),
                new ThirdObject(
                    'a',
                    0,
                ),
            ],
        ), new TestException);
    }

    /**
     * @test
     */
    public function createPropChecker__afterCall__OK()
    {
        $third = new ThirdObject(
            'a',
            2,
        );

        PropCheckFacade::check(new FirstObject(
            "aa",
            new SecondObject(
                'a',
                new ThirdObject(
                    'a',
                    1,
                ),
            ),
            [
                $third,
                $third,
                $third,
            ],
        ));

        $this->assertEquals($third->increment, 6);
    }
}

class FirstObject
{
    public function __construct(
        #[NotEmpty]
        private string $a,
        #[Effect]
        private SecondObject $b,
        #[Effect]
        private array $c,
    ) {
        //
    }
}

class SecondObject
{
    public function __construct(
        #[NotEmpty]
        private string $a,
        #[Effect]
        private ThirdObject $b,
    ) {
        //
    }
}

#[AfterCall('valid')]
class ThirdObject
{
    public int $increment = 0;

    public function __construct(
        #[NotEmpty]
        private string $a,
        #[NotEmpty]
        #[Max(100)]
        private int $b,
    ) {
        //
    }

    private function valid()
    {
        $this->increment += $this->b;
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
        #[MinLength(1, false, "[:class::$:property] not_match :min")]
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
