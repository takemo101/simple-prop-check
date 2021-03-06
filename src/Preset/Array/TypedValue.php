<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Takemo101\SimplePropCheck\Support\CheckType;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TypedValue extends ArrayValidatable
{
    /**
     * @var CheckType
     */
    private readonly CheckType $type;

    /**
     * constructor
     *
     * @param string $type
     * @param string|null $message
     */
    public function __construct(
        string $type,
        private readonly ?string $message = null,
    ) {
        $this->type = new CheckType($type);
    }

    /**
     * get validate the data of the property
     *
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        foreach ($data as $value) {
            if (!$this->type->verify($value)) {
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
        return $this->message ?? "[:class::$:property] data value type does not match :type";
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            'type' => $this->type->getTypeName(),
        ];
    }
}
