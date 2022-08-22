<?php

declare(strict_types=1);

namespace App\Classes\Services\Currencies;

use App\Classes\Clients\ExchangeRateClient;
use App\Classes\Constants;
use App\Classes\ValueObjects\Currencies\ExchangeRateRequest;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class ExchangesCurrencyRate {
    /** @var ExchangeRateClient */
    private ExchangeRateClient $exchangeRateClient;

    /**
     * ExchangesCurrencyRate constructor.
     *
     * @param ExchangeRateClient $exchangeRateClient
     */
    public function __construct(ExchangeRateClient $exchangeRateClient) {
        $this->exchangeRateClient = $exchangeRateClient;
    }

    /**
     * @param string $convertedFrom
     * @param string $convertedTo
     * @param float  $amount
     *
     * @return float
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     */
    public function execute(string $convertedFrom, string $convertedTo, float $amount): float {
        $currencyRateObject = $this->exchangeRateClient->makeRequest(new ExchangeRateRequest(Constants::EXCHANGE_RATE_METHOD,
            Constants::EXCHANGE_RATE_ENDPOINT))->rates;

        return ($amount / $currencyRateObject->{$convertedFrom}) * $currencyRateObject->{$convertedTo};
    }
}
