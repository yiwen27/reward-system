<?php

declare(strict_types=1);

namespace App\Classes\Clients;

use App\Classes\Constants;
use App\Classes\ValueObjects\Currencies\ExchangeRateRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class ExchangeRateClient {
    /**
     * @param ExchangeRateRequest $exchangeRateRequest
     *
     * @return object
     * @throws InternalErrorException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function makeRequest(ExchangeRateRequest $exchangeRateRequest): object {
        try {
            $client = new Client(['base_uri' => Constants::EXCHANGE_RATE_BASE_URI]);

            $response = $client->request($exchangeRateRequest->getMethod(),
                sprintf('%s?app_id=%s', $exchangeRateRequest->getEndpoint(),
                    config()->get('trading.auth.exchange_rate_app_id')), [
                    'headers' => [
                        'Accept'       => 'application/json',
                        'Content-Type' => 'application/json',
                    ]
                ]);

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $exception) {
            throw new InternalErrorException($exception->getMessage());
        }
    }
}
