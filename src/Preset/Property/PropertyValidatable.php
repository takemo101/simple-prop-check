<?php

namespace Takemo101\SimplePropCheck\Preset\Property;

use Takemo101\SimplePropCheck\AbstractValidatable;
use Takemo101\SimplePropCheck\PropertyComparable;

/**
 * @extends AbstractValidatable<mixed>
 * @implements PropertyComparable<mixed>
 */
abstract class PropertyValidatable extends AbstractValidatable implements PropertyComparable
{
    /**
     * constructor
     *
     * @param string $name
     * @param string|null $message
     */
    public function __construct(
        protected readonly string $name,
        protected readonly ?string $message = null,
    ) {
        //
    }

    /**
     * validate the data of the property
     *
     * @param mixed $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return true;
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
