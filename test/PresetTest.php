<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\Preset\String\{
    URL,
    Email,
    LengthBetween,
    LengthMax,
    LengthMin,
    Pattern,
};
use Takemo101\SimplePropCheck\Preset\Array\{
    SizeBetween,
    SizeMax,
    SizeMin,
    Unique,
};
use Takemo101\SimplePropCheck\Preset\Numeric\{
    Between,
    Max,
    Min,
    Negative,
    Positive,
};
use Takemo101\SimplePropCheck\Preset\{
    NotNull,
    NotEmpty,
};


/**
 * preset attribute test
 */
class PresetTest extends TestCase
{
    /**
     * @test
     */
    public function verifyString__OK()
    {
        $v = new URL();
        $this->assertTrue($v->verify('http://aaa.com/page/'));
        $this->assertFalse($v->verify('seraaa.com/page/'));

        $v = new Email();
        $this->assertTrue($v->verify('aaa@gmail.com'));
        $this->assertFalse($v->verify('http://aaa.com/page/'));

        $v = new LengthBetween(1, 7);
        $this->assertTrue($v->verify('abcdefg'));
        $this->assertFalse($v->verify('abcdefgh'));
        $this->assertTrue($v->verify('あいうえおかき'));

        $v = new LengthMax(7);
        $this->assertTrue($v->verify('abcdefg'));
        $this->assertFalse($v->verify('abcdefgh'));
        $this->assertTrue($v->verify('あいうえおかき'));

        $v = new LengthMax(7, false);
        $this->assertFalse($v->verify('abcdefg'));
        $this->assertTrue($v->verify('abcdef'));
        $this->assertFalse($v->verify('あいうえおかき'));

        $v = new LengthMin(3);
        $this->assertTrue($v->verify('abc'));
        $this->assertFalse($v->verify('ab'));
        $this->assertTrue($v->verify('あいう'));

        $v = new LengthMin(3, false);
        $this->assertFalse($v->verify('abc'));
        $this->assertTrue($v->verify('abcd'));
        $this->assertFalse($v->verify('あいう'));

        $v = new Pattern('/[a]+/');
        $this->assertTrue($v->verify('abc'));
        $this->assertFalse($v->verify('bcd'));
    }

    /**
     * @test
     */
    public function verifyArray__OK()
    {
        $v = new SizeBetween(2, 5);
        $this->assertTrue($v->verify([1, 2.5, 4]));
        $this->assertTrue($v->verify([1, 2.5]));
        $this->assertFalse($v->verify([1, 2.5, 4, 1, 1, 2]));

        $v = new SizeMax(2);
        $this->assertFalse($v->verify([1, 2.5, 4]));
        $this->assertTrue($v->verify([1, 2.5]));

        $v = new SizeMax(2, false);
        $this->assertFalse($v->verify([1, 2.5]));

        $v = new SizeMin(3);
        $this->assertTrue($v->verify([1, 2.5, 4]));
        $this->assertFalse($v->verify([1, 2.5]));

        $v = new SizeMin(3, false);
        $this->assertFalse($v->verify([1, 2.5, 4]));

        $v = new Unique;
        $this->assertTrue($v->verify([1, 2, 3, "a"]));
        $this->assertFalse($v->verify([1, 2, 2, "a"]));
    }

    /**
     * @test
     */
    public function verifyNumeric__OK()
    {
        $v = new Between(2, 5);
        $this->assertTrue($v->verify(2));
        $this->assertTrue($v->verify(5));
        $this->assertFalse($v->verify(1));

        $v = new Max(4);
        $this->assertTrue($v->verify(4));
        $this->assertFalse($v->verify(5));

        $v = new Max(4, false);
        $this->assertFalse($v->verify(4));
        $this->assertTrue($v->verify(3));

        $v = new Min(4);
        $this->assertTrue($v->verify(4));
        $this->assertFalse($v->verify(3));

        $v = new Min(4, false);
        $this->assertFalse($v->verify(4));
        $this->assertTrue($v->verify(5));

        $v = new Positive;
        $this->assertFalse($v->verify(-1));
        $this->assertTrue($v->verify(0));
        $this->assertTrue($v->verify(1));

        $v = new Positive(false);
        $this->assertFalse($v->verify(0));
        $this->assertTrue($v->verify(1));

        $v = new Negative;
        $this->assertFalse($v->verify(1));
        $this->assertTrue($v->verify(-1));
        $this->assertTrue($v->verify(0));

        $v = new Negative(false);
        $this->assertFalse($v->verify(0));
        $this->assertTrue($v->verify(-1));
    }

    /**
     * @test
     */
    public function verify__OK()
    {
        $v = new NotEmpty;
        $this->assertTrue($v->verify(1));
        $this->assertTrue($v->verify(0.1));
        $this->assertTrue($v->verify("a"));

        $this->assertFalse($v->verify(0));
        $this->assertFalse($v->verify(""));
        $this->assertFalse($v->verify([]));
        $this->assertFalse($v->verify(null));

        $v = new NotNull;
        $this->assertTrue($v->verify(1));
        $this->assertTrue($v->verify(0.1));
        $this->assertTrue($v->verify("a"));

        $this->assertTrue($v->verify(0));
        $this->assertTrue($v->verify(""));
        $this->assertTrue($v->verify([]));
        $this->assertFalse($v->verify(null));
    }
}