<?php

declare(strict_types=1);

namespace App\Classes;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
final class Constants {
    // order status
    public const ORDER_STATUS_COMPLETE = 'COMPLETE';
    public const ORDER_STATUS_PENDING = 'PENDING';

    // currency type
    public const CURRENCY_TYPE_AUD = 'AUD';
    public const CURRENCY_TYPE_MYR = 'MYR';
    public const CURRENCY_TYPE_SGD = 'SGD';
    public const CURRENCY_TYPE_USD = 'USD';
    public const SUPPORTED_CURRENCIES = [
        self::CURRENCY_TYPE_AUD,
        self::CURRENCY_TYPE_MYR,
        self::CURRENCY_TYPE_SGD,
        self::CURRENCY_TYPE_USD
    ];

    public const EXCHANGE_RATE_BASE_URI = 'https://openexchangerates.org/api/';
    public const EXCHANGE_RATE_ENDPOINT = 'latest.json';
    public const EXCHANGE_RATE_METHOD = 'GET';

    public const POINT_TO_USD_CONVERSION_RATE = 0.01;
}
