<?php

namespace Takemo101\SimplePropCheck;

use InvalidArgumentException;

/**
 * exception message analyzer
 */
final class MessageAnalyzer
{
    /**
     * @var string
     */
    private string $prefix;

    /**
     * constructor
     *
     * @param string $prefix
     */
    public function __construct(
        string $prefix = ':',
    ) {
        $prefix = trim($prefix);

        if (!$prefix) {
            throw new InvalidArgumentException('constructor argument error: prefix is empty');
        }

        $this->prefix = $prefix;
    }

    /**
     * exception message analyze
     *
     * @param string $message
     * @param array<string,mixed> $parameters
     * @return string
     */
    public function analyze(string $message, array $parameters): string
    {
        foreach ($parameters as $key => $data) {
            if (is_string($data) || is_array($data)) {
                $message = str_replace("{$this->prefix}{$key}", $data, $message);
            }
        }

        return $message;
    }
}
