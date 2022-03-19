<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\Preset\NotEmpty;
use Takemo101\SimplePropCheck\Sanitize\String\{
    Trim,
    RTrim,
    LTrim,
    Replace,
};
use Takemo101\SimplePropCheck\PropCheckFacade;
use DomainException;

/**
 * sanitize attribute test
 */
class SanitizeTest extends TestCase
{
    /**
     * @test
     */
    public function sanitizeString__OK()
    {
        $s = new Trim;
        $this->assertEquals($s->sanitize("  data \n"), 'data');

        $s = new RTrim;
        $this->assertEquals($s->sanitize("  data \n"), '  data');

        $s = new LTrim;
        $this->assertEquals($s->sanitize("  data \n"), "data \n");

        $s = new Replace(['d', 't'], 'a');
        $this->assertEquals($s->sanitize("data"), 'aaaa');
    }

    /**
     * @test
     */
    public function createAttribute__OK()
    {
        $obj = PropCheckFacade::exception(new TestSanitize("  data \n"));
        $this->assertEquals($obj->name, 'aaaa');
    }

    /**
     * @test
     */
    public function createAttribute__NG()
    {
        $this->expectException(DomainException::class);
        $obj = PropCheckFacade::exception(new TestSanitize("  \n"));
    }
}

class TestSanitize
{
    public function __construct(
        #[Trim]
        #[Replace(['d', 't'], 'a')]
        #[NotEmpty]
        public string $name,
    ) {
        //
    }
}
