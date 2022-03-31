<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\SimplePropCheck\Preset\String\{
    Email,
};
use Takemo101\SimplePropCheck\Preset\Numeric\{
    Positive,
};
use Takemo101\SimplePropCheck\Preset\{
    NotEmpty,
};
use Takemo101\SimplePropCheck\{
    PropCheckFacade,
    Effect,
    IgnoreEffect,
    AfterCall,
};
use Exception;
use DomainException;

/**
 * entity test
 */
class EntityTest extends TestCase
{
    /**
     * @test
     */
    public function createEntity__OK()
    {
        $entity = new TestEntity(
            new TestName('hello'),
            new TestEmail('xxxx@xxx.com'),
            new TestAge(20),
        );

        $this->assertEquals($entity->getAge()->value(), 20);
    }

    /**
     * @test
     */
    public function createEntity__entityError__NG()
    {
        $this->expectException(Exception::class);

        $entity = new TestEntity(
            new TestName('hello'),
            new TestEmail('xxxx@xxx.com'),
            new TestAge(65),
        );
    }

    /**
     * @test
     */
    public function createEntity__propertyError__NG()
    {
        $this->expectException(DomainException::class);

        $entity = new TestEntity(
            new TestName(''),
            new TestEmail('xxxx@xxx.com'),
            new TestAge(65),
        );
    }

    /**
     * @test
     */
    public function ignoreEffect__forObject__OK()
    {
        $entity = new TestIgnoreEffectObject(
            new TestTitle(''),
        );

        $this->assertEquals($entity->title->title, '');
    }

    /**
     * @test
     */
    public function ignoreEffect__forArray__OK()
    {
        $entity = new TestIgnoreEffectArray(
            [
                new TestTitle(''),
                new TestTitle(''),
            ],
        );

        $this->assertEquals($entity->titles[0]->title, '');
        $this->assertEquals($entity->titles[1]->title, '');
    }
}

#[AfterCall('canVerified')]
class TestEntity
{
    public function __construct(
        #[Effect]
        private TestName $name,
        #[Effect]
        private TestEmail $email,
        #[Effect]
        private TestAge $age,
    ) {
        PropCheckFacade::exception($this);
    }

    private function canVerified(): void
    {
        if ($this->age->isElderly()) {
            throw new Exception('error');
        }
    }

    public function getAge(): TestAge
    {
        return $this->age;
    }
}

class TestName
{
    public function __construct(
        #[NotEmpty]
        private string $name,
    ) {
        //
    }
}

class TestAge
{
    public function __construct(
        #[Positive]
        private int $age,
    ) {
        //
    }

    public function isElderly(): bool
    {
        return $this->age > 60;
    }

    public function value(): int
    {
        return $this->age;
    }
}

class TestEmail
{
    public function __construct(
        #[Email]
        private string $email,
    ) {
        //
    }
}

class TestIgnoreEffectObject
{
    public function __construct(
        #[Effect]
        public TestTitle $title,
    ) {
        PropCheckFacade::exception($this);
    }
}

class TestIgnoreEffectArray
{
    public function __construct(
        #[Effect]
        public array $titles,
    ) {
        //
    }
}

#[IgnoreEffect]
class TestTitle
{
    public function __construct(
        #[NotEmpty]
        public string $title,
    ) {
        //
    }
}
