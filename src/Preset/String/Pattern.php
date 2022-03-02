<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Pattern extends StringValidatable
{

    /**
     * constructor
     *
     * @param string $pattern
     * @param string|null $message
     */
    public function __construct(
        private string $pattern,
        private ?string $message = null,
    ) {
        //
    }

    /**
     * get validate the data of the property
     *
     * @param string $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return (bool)preg_match($this->pattern, $data);
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "data is not match pattern :pattern";
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            'pattern' => $this->pattern,
        ];
    }
}
