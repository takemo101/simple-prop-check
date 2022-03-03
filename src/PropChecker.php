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
     * checks
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

        CallMethod::toCall($this->object);

        return true;
    }

    /**
     * checks and effects
     *
     * @return boolean true if the property is OK
     */
    public function effect(): bool
    {
        $objects = ObjectToEffectObjects::toArray($this->object);

        foreach ($objects as $object) {
            if (!(new self(
                $object,
                $this->analyzer,
                $this->factory,
            ))->effect()) {
                return false;
            }
        }

        return $this->check();
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
                $placeholders['class'] = $prop->getClassName();

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

        CallMethod::toCall($this->object);
    }

    /**
     * checks and effects with throw exception
     *
     * @return void
     * @throws Throwable
     */
    public function effectWithException(): void
    {
        $objects = ObjectToEffectObjects::toArray($this->object);

        foreach ($objects as $object) {
            (new self(
                $object,
                $this->analyzer,
                $this->factory,
            ))->effectWithException();
        }

        $this->checkWithException();
    }

    /**
     * create Exception
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
