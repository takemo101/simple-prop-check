<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Exception\{
    ExceptionFactory,
    Exception,
};
use Throwable;

/**
 * property checker factory class
 */
final class PropCheckerFactory
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
     * check
     *
     * @param object $object
     * @return boolean
     */
    public static function check(object $object): bool
    {
        return self::factory($object)->check();
    }

    /**
     * check with exception
     *
     * @param object $object
     * @return void
     * @throws Throwable
     */
    public static function exception(object $object): void
    {
        self::factory($object)->checkWithException();
    }

    /**
     * factory
     *
     * @param object $object
     * @return PropChecker
     */
    public static function factory(object $object): PropChecker
    {
        return new PropChecker(
            $object,
            new MessageAnalyzer,
            self::getExceptionFactory()->copy(),
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
