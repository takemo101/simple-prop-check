<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Attribute;
use Takemo101\SimplePropCheck\Validatable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Each extends ArrayValidatable
{
    /**
     * @var Validatable|null
     */
    private ?Validatable $lastValidate;

    /**
     * constructor
     *
     * @param Validatable[] $validates
     * @param string|null $message
     */
    public function __construct(
        private array $validates,
        private ?string $message = null,
    ) {
        //
    }

    /**
     * validate the data of the property
     *
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        foreach ($data as $d) {
            if (!$this->validate($d)) {
                return false;
            }
        }

        return true;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->lastValidate ?
            $this->lastValidate->message() :
            "[:class::$:property] data is error"
        );
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            //
        ];
    }

    /**
     * verification of each data in the array
     *
     * @param mixed $data
     * @return boolean
     */
    private function validate(mixed $data): bool
    {
        foreach ($this->validates as $validate) {
            if (!$validate->canVerified($data)) {
                continue;
            }

            if (!$validate->verify($data)) {
                $this->lastValidate = $validate;

                return false;
            }
        }

        return true;
    }
}
