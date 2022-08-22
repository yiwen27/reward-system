<?php

declare(strict_types=1);

namespace App\Classes\Services\Points;

use App\Classes\Constants;
use App\Classes\Services\Currencies\ExchangesCurrencyRate;
use App\Classes\ValueObjects\Points\PointRedemption;
use App\Classes\ValueObjects\Points\PointReward;
use App\Models\Order;
use App\Repositories\Eloquent\Orders;
use App\Repositories\Eloquent\PointRedemptionHistories;
use App\Repositories\Eloquent\RewardPoints;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class RedeemsPoints {
    /** @var Orders */
    private Orders $orders;

    /** @var RewardPoints */
    private RewardPoints $rewardPoints;

    /** @var ExchangesCurrencyRate */
    private ExchangesCurrencyRate $exchangesCurrencyRate;

    /** @var PointRedemptionHistories */
    private PointRedemptionHistories $pointRedemptionHistories;

    /** @var UpdatesRewardPointsRedemptionStatus */
    private UpdatesRewardPointsRedemptionStatus $updatesRewardPointsRedemptionStatus;

    /**
     * RedeemsPoints constructor.
     *
     * @param Orders                              $orders
     * @param RewardPoints                        $rewardPoints
     * @param ExchangesCurrencyRate               $exchangesCurrencyRate
     * @param PointRedemptionHistories            $pointRedemptionHistories
     * @param UpdatesRewardPointsRedemptionStatus $updatesRewardPointsRedemptionStatus
     */
    public function __construct(
        Orders $orders,
        RewardPoints $rewardPoints,
        ExchangesCurrencyRate $exchangesCurrencyRate,
        PointRedemptionHistories $pointRedemptionHistories,
        UpdatesRewardPointsRedemptionStatus $updatesRewardPointsRedemptionStatus
    ) {
        $this->orders                              = $orders;
        $this->rewardPoints                        = $rewardPoints;
        $this->exchangesCurrencyRate               = $exchangesCurrencyRate;
        $this->pointRedemptionHistories            = $pointRedemptionHistories;
        $this->updatesRewardPointsRedemptionStatus = $updatesRewardPointsRedemptionStatus;
    }

    /**
     * @param Order $order
     *
     * @return PointRedemption
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     */
    public function execute(Order $order): PointRedemption {
        // Retrieve customer's total valid reward points
        $rewardPointsRecords = $this->rewardPoints->getAvailableRewardPointsByCustomerId($order->customer_id);

        $totalPrice = $order->total_price;

        // Convert sales amount to equivalent amount in USD if the sales amount is of other currency
        if ($order->currency !== Constants::CURRENCY_TYPE_USD) {
            $totalPrice = round($this->exchangesCurrencyRate->execute($order->currency, Constants::CURRENCY_TYPE_USD,
                $totalPrice), 2);
        }

        // Bail early if customer has no reward points
        if (count($rewardPointsRecords) === 0) {
            return PointRedemption::createAfterRedemption(0, $totalPrice);
        }

        // Calculate total points required and determine available points to be redeemed
        $totalPointsRequired  = $totalPrice / Constants::POINT_TO_USD_CONVERSION_RATE;
        $totalPointsAvailable = $rewardPointsRecords->sum('balance_points');
        $redeemedPoints       = $totalPointsAvailable >= $totalPointsRequired ? $totalPointsRequired : $totalPointsAvailable;

        // Get all record identifiers of reward points to be redeemed
        $recordIdentifiers = $rewardPointsRecords->pluck('id')->all();

        // Update reward points redemption status
        $this->updatesRewardPointsRedemptionStatus->execute($order->id, $redeemedPoints, $recordIdentifiers);

        return PointRedemption::createAfterRedemption($redeemedPoints,
            $totalPrice - ($redeemedPoints * Constants::POINT_TO_USD_CONVERSION_RATE));
    }
}
