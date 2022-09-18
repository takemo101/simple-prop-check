<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class URL extends StringValidatable
{
    /**
     * @var array<string,string>
     */
    private const URLEncodePairs = [
        '%2D' => '-',
        '%5F' => '_',
        '%2E' => '.',
        '%21' => '!',
        '%7E' => '~',
        '%2A' => '*',
        '%27' => "'",
        '%28' => '(',
        '%29' => ')',
        '%3B' => ';',
        '%2C' => ',',
        '%2F' => '/',
        '%3F' => '?',
        '%3A' => ':',
        '%40' => '@',
        '%26' => '&',
        '%3D' => '=',
        '%2B' => '+',
        '%24' => '$',
        '%23' => '#',
        '%5B' => '[',
        '%5D' => ']',
    ];

    /**
     * constructor
     *
     * @param string|null $message
     */
    public function __construct(
        private readonly ?string $message = null,
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
        $encodedURL = $this->encode($data);
        return (bool)filter_var($encodedURL, FILTER_VALIDATE_URL);
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] data is data is not a url";
    }

    /**
     * encode url
     *
     * @param string $url
     * @return string
     */
    public function encode(string $url): string
    {
        return strtr(rawurlencode($url), self::URLEncodePairs);
    }
}
