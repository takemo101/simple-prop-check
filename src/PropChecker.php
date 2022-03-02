<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Exception\ExceptionFactory;
use Throwable;

/**
 * property check class
 */
final class PropChecker
{
    /**
     * constructor
     *
     * @param object $object
     * @param ExceptionFactory $factory
     */
    public function __construct(
        private object $object,
        private MessageAnalyzer $analyzer,
        private ExceptionFactory $factory,
    ) {
        //
    }

    /**
     * check
     *
     * @return boolean true if the property is OK
     */
    public function check(): bool
    {
        $props = ObjectToPropAttributes::toArray($this->object);

        foreach ($props as $prop) {

            if ($prop->verify()) {
                return false;
            }
        }

        return true;
    }

    /**
     * check with throw exception
     *
     * @return void
     * @throws Throwable
     */
    public function checkWithException(): void
    {
        $props = ObjectToPropAttributes::toArray($this->object);

        foreach ($props as $prop) {

            if ($validatable = $prop->verify()) {

                $placeholders = $validatable->placeholders();
                $placeholders['property'] = $prop->getPropertyName();

                $message = $this->analyzer->analyze(
                    $validatable->message(),
                    $placeholders,
                );

                throw $this->createException(
                    $message,
                    $prop->getExceptionFactory(),
                );
            }
        }
    }

    /**
     * create exception
     *
     * @param ExceptionFactory|null $factory
     * @return Throwable
     */
    private function createException(
        string $message,
        ?ExceptionFactory $factory = null,
    ): Throwable {
        if ($factory) {
            return $factory->factory($message);
        }

        return $this->factory->factory($message);
    }
}
