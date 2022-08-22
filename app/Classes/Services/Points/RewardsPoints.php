<?php

declare(strict_types=1);

namespace App\Classes\Services\Points;

use App\Classes\Constants;
use App\Classes\Services\Currencies\ExchangesCurrencyRate;
use App\Classes\ValueObjects\Points\PointReward;
use App\Models\Order;
use App\Models\RewardPoint;
use App\Repositories\Eloquent\RewardPoints;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class RewardsPoints {
    /** @var RewardPoints */
    private RewardPoints $rewardPoints;

    /** @var ExchangesCurrencyRate */
    private ExchangesCurrencyRate $exchangesCurrencyRate;

    /**
     * RedeemsPoints constructor.
     *
     * @param RewardPoints          $rewardPoints
     * @param ExchangesCurrencyRate $exchangesCurrencyRate
     */
    public function __construct(
        RewardPoints $rewardPoints,
        ExchangesCurrencyRate $exchangesCurrencyRate
    ) {
        $this->rewardPoints          = $rewardPoints;
        $this->exchangesCurrencyRate = $exchangesCurrencyRate;
    }

    /**
     * @param Order $order
     *
     * @return Model
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     */
    public function execute(Order $order): Model {
        try {
            // Make sure points are not yet rewarded for an order
            $this->rewardPoints->findWhere([
                'customer_id' => $order->customer_id,
                'order_id'    => $order->id
            ]);

            throw new ConflictHttpException('Points for this sales have been rewarded.');
        } catch (ModelNotFoundException $exception) {
            $totalPrice = $order->total_price;

            // Convert sales amount to equivalent amount in USD if the sales amount is of other currency
            if ($order->currency !== Constants::CURRENCY_TYPE_USD) {
                $totalPrice = $this->exchangesCurrencyRate->execute($order->currency, Constants::CURRENCY_TYPE_USD,
                    $totalPrice);
            }

            $pointRewardObject = PointReward::createPointRewardObject($order->customer_id, $order->id,
                round($totalPrice, 2), $order->created_at->addYear()->toDateTimeString());

            return $this->rewardPoints->createRewardPointsTransaction($pointRewardObject);
        }
    }
}
