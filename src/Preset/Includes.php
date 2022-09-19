<?php

namespace Takemo101\SimplePropCheck\Preset;

use Takemo101\SimplePropCheck\AbstractValidatable;
use Attribute;
use InvalidArgumentException;

/**
 * @extends AbstractValidatable<mixed>
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Includes extends AbstractValidatable
{
    /**
     * constructor
     *
     * @param mixed[] $includes
     * @param string|null $message
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected readonly array $includes,
        protected readonly ?string $message = null,
    ) {
        if (empty($includes)) {
            throw new InvalidArgumentException('constructor argument error: includes is empty');
        }
    }

    /**
     * validate the data of the property
     *
     * @param mixed $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return in_array($data, $this->includes);
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? '[:class::$:property] data is not included';
    }
}
