<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Takemo101\SimplePropCheck\Support\CheckType;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TypedKey extends ArrayValidatable
{
    /**
     * @var CheckType
     */
    private CheckType $type;

    /**
     * constructor
     *
     * @param string $type
     * @param string|null $message
     */
    public function __construct(
        string $type,
        private ?string $message = null,
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
        $keys = array_keys($data);
        foreach ($keys as $key) {
            if (!$this->type->verify($key)) {
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
        return $this->message ?? "[:class::$:property] data key type does not match :type";
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
