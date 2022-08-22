<?php

declare(strict_types=1);

namespace App\Classes\ValueObjects\Currencies;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class ExchangeRateRequest {
    /** @var string */
    private string $method;

    /** @var string */
    private string $endpoint;

    /**
     * ExchangeRateRequest constructor.
     *
     * @param string $method
     * @param string $endpoint
     */
    public function __construct(string $method, string $endpoint) {
        $this->method   = $method;
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string {
        return $this->endpoint;
    }
}
