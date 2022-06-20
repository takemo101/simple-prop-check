<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Takemo101\SimplePropCheck\Support\CheckType;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TypedMap extends ArrayValidatable
{
    /**
     * @var CheckType
     */
    private readonly CheckType $keyType;

    /**
     * @var CheckType
     */
    private readonly CheckType $valueType;

    /**
     * constructor
     *
     * @param string $keyType
     * @param string $valueType
     * @param string|null $message
     */
    public function __construct(
        string $keyType,
        string $valueType,
        private ?string $message = null,
    ) {
        $this->keyType = new CheckType($keyType);
        $this->valueType = new CheckType($valueType);
    }

    /**
     * get validate the data of the property
     *
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        foreach ($data as $key => $value) {
            if (!($this->keyType->verify($key) && $this->valueType->verify($value))) {
                return false;
            }
        }
        return true;
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] data type does not match key=:key or value=:value";
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            'key' => $this->keyType->getTypeName(),
            'value' => $this->valueType->getTypeName(),
        ];
    }
}
