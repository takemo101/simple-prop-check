<?php

namespace Takemo101\SimplePropCheck\Support;

use InvalidArgumentException;

/**
 * exception message analyzer
 */
final class MessageAnalyzer
{
    /**
     * @var string
     */
    private readonly string $prefix;

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
     * @param array<string,mixed> $placeholders
     * @return string
     */
    public function analyze(string $message, array $placeholders): string
    {
        foreach ($placeholders as $key => $data) {

            if (!is_array($data)) {
                $data = strval($data);
            }

            $message = str_replace("{$this->prefix}{$key}", $data, $message);
        }

        return $message;
    }
}
