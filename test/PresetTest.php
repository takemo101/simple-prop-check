<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\Preset\String\{
    URL,
    Email,
    BetweenLength,
    MaxLength,
    MinLength,
    Pattern,
};
use Takemo101\SimplePropCheck\Preset\Array\{
    BetweenSize,
    MaxSize,
    MinSize,
    Unique,
    TypedKey,
    TypedValue,
    TypedMap,
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

        $v = new BetweenLength(1, 7);
        $this->assertTrue($v->verify('abcdefg'));
        $this->assertFalse($v->verify('abcdefgh'));
        $this->assertTrue($v->verify('あいうえおかき'));

        $v = new MaxLength(7);
        $this->assertTrue($v->verify('abcdefg'));
        $this->assertFalse($v->verify('abcdefgh'));
        $this->assertTrue($v->verify('あいうえおかき'));

        $v = new MaxLength(7, false);
        $this->assertFalse($v->verify('abcdefg'));
        $this->assertTrue($v->verify('abcdef'));
        $this->assertFalse($v->verify('あいうえおかき'));

        $v = new MinLength(3);
        $this->assertTrue($v->verify('abc'));
        $this->assertFalse($v->verify('ab'));
        $this->assertTrue($v->verify('あいう'));

        $v = new MinLength(3, false);
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
        $v = new BetweenSize(2, 5);
        $this->assertTrue($v->verify([1, 2.5, 4]));
        $this->assertTrue($v->verify([1, 2.5]));
        $this->assertFalse($v->verify([1, 2.5, 4, 1, 1, 2]));

        $v = new MaxSize(2);
        $this->assertFalse($v->verify([1, 2.5, 4]));
        $this->assertTrue($v->verify([1, 2.5]));

        $v = new MaxSize(2, false);
        $this->assertFalse($v->verify([1, 2.5]));

        $v = new MinSize(3);
        $this->assertTrue($v->verify([1, 2.5, 4]));
        $this->assertFalse($v->verify([1, 2.5]));

        $v = new MinSize(3, false);
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

    /**
     * @test
     */
    public function verifyTypedMap__OK()
    {
        $v = new TypedKey('string|int');
        $this->assertTrue($v->verify([
            'a' => '',
            1 => '',
        ]));

        $v = new TypedKey('string');
        $this->assertTrue($v->verify([
            'a' => '',
            'b' => '',
        ]));
        $this->assertFalse($v->verify([
            'a' => '',
            1 => '',
        ]));

        $v = new TypedKey('integer');
        $this->assertTrue($v->verify([
            1 => '',
            2 => '',
        ]));
        $this->assertFalse($v->verify([
            'a' => '',
            1 => '',
        ]));


        $v = new TypedValue('integer');
        $this->assertTrue($v->verify([
            1,
            2,
        ]));
        $this->assertFalse($v->verify([
            'a',
            1,
        ]));

        $v = new TypedValue('string|integer|float');
        $this->assertFalse($v->verify([
            1,
            2,
            new TestValue,
        ]));
        $this->assertTrue($v->verify([
            'a',
            1,
            1.1,
        ]));

        $v = new TypedValue('string|integer|float|' . TestValue::class);
        $this->assertTrue($v->verify([
            1,
            2,
            new TestValue,
        ]));

        $v = new TypedValue(TestValue::class);
        $this->assertFalse($v->verify([
            1,
            2,
            new TestValue,
        ]));
        $this->assertTrue($v->verify([
            new TestValue,
            new TestValue,
        ]));

        $v = new TypedMap('integer', 'string');
        $this->assertTrue($v->verify([
            1 => '',
            2 => '',
        ]));
        $this->assertFalse($v->verify([
            'a' => '',
            1 => '',
        ]));
        $this->assertFalse($v->verify([
            'a' => '',
            'b' => 1,
        ]));

        $v = new TypedMap('integer', TestValue::class);
        $this->assertTrue($v->verify([
            new TestValue,
            new TestValue,
        ]));
        $this->assertFalse($v->verify([
            new TestValue,
            'a',
        ]));

        $v = new TypedMap('string|int', 'string|' . TestValue::class);
        $this->assertTrue($v->verify([
            1 => '',
            2 => new TestValue,
        ]));
        $this->assertFalse($v->verify([
            'a' => '',
            1 => 1,
        ]));
    }
}

class TestValue
{
    //
}

enum TestEnum
{
    case A;
    case B;
    case C;
}
