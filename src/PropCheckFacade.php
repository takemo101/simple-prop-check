<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Exception\{
    ExceptionFactory,
    Exception,
};
use Takemo101\SimplePropCheck\Support\MessageAnalyzer;
use Throwable;

/**
 * property check facade class
 */
final class PropCheckFacade
{
    /**
     * @var ExceptionFactory|null
     */
    private static ?ExceptionFactory $factory = null;

    /**
     * private constructor
     */
    private function __construct()
    {
        //
    }

    /**
     * checks and effects
     *
     * @param object $object
     * @return boolean
     */
    public static function check(object $object): bool
    {
        return self::factory($object)->effect();
    }

    /**
     * check with throw exception
     *
     * @param object $object
     * @param ExceptionFactory|null $exceptionFactory
     * @return object
     * @throws Throwable
     */
    public static function exception(object $object, ?ExceptionFactory $exceptionFactory = null): object
    {
        return self::factory($object, $exceptionFactory)->effectWithException();
    }

    /**
     * factory
     *
     * @param object $object
     * @param ExceptionFactory|null $exceptionFactory
     * @return PropChecker
     */
    public static function factory(object $object, ?ExceptionFactory $exceptionFactory = null): PropChecker
    {
        return new PropChecker(
            $object,
            new MessageAnalyzer,
            $exceptionFactory
                ? $exceptionFactory->copy()
                : self::getExceptionFactory()->copy(),
        );
    }

    /**
     * set default exception factory
     *
     * @param ExceptionFactory $factory
     * @return void
     */
    public static function setExceptionFactory(
        ExceptionFactory $factory
    ): void {
        self::$factory = $factory;
    }

    /**
     * get default exception factory
     *
     * @return ExceptionFactory
     */
    public static function getExceptionFactory(): ExceptionFactory
    {
        if (!self::$factory) {
            self::$factory = new Exception;
        }

        return self::$factory;
    }
}
