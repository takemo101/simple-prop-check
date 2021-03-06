<?php

namespace Takemo101\SimplePropCheck\Support;

use InvalidArgumentException;

/**
 * check the value type
 */
final class CheckType
{
    const UnionSeparator = '|';

    const IntersectionSeparator = '&';

    /**
     * @var string[]
     */
    private readonly array $types;

    /**
     * @var boolean
     */
    private readonly bool $isUnionType;

    /**
     * constructor
     *
     * @param string $type
     */
    public function __construct(
        string $type,
    ) {
        $this->isUnionType = strpos($type, self::IntersectionSeparator) === false ? true : false;

        $separator = $this->isUnionType ? self::UnionSeparator : self::IntersectionSeparator;

        $types = array_filter(
            explode(
                $separator,
                str_replace(' ', '', trim($type))
            )
        );

        if (!count($types)) {
            throw new InvalidArgumentException('constructor argument error: type name is empty');
        }

        $this->types = $types;
    }

    /**
     * get type name
     *
     * @return string
     */
    public function getTypeName(): string
    {
        return implode(self::UnionSeparator, $this->types);
    }

    /**
     * verify that the value matches the type
     *
     * @param mixed $data
     * @return boolean
     */
    public function verify($data): bool
    {
        $result = false;

        foreach ($this->types as $type) {
            if ($this->check($type, $data)) {
                $result = true;
            }
        }

        return $this->isUnionType ? $result : !$result;
    }

    /**
     * check type match
     *
     * @param mixed $data
     * @return boolean
     */
    private function check(string $type, $data): bool
    {
        // check nullable
        if (strpos($type, '?') === 0 && is_null($data)) {
            return true;
        }

        switch ($type) {
            case 'array':
                return is_array($data);
            case 'iterable':
                return is_iterable($data);
            case 'bool':
            case 'boolean':
                return is_bool($data);
            case 'callable':
                return is_callable($data);
            case 'float':
            case 'double':
                return is_float($data);
            case 'int':
            case 'integer':
                return is_int($data);
            case 'null':
                return $data === null;
            case 'numeric':
                return is_numeric($data);
            case 'object':
                return is_object($data);
            case 'resource':
                return is_resource($data);
            case 'scalar':
                return is_scalar($data);
            case 'string':
                return is_string($data);
            case 'mixed':
                return true;
        }

        return $data instanceof $type;
    }
}
