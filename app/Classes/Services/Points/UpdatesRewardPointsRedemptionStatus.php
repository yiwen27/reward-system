<?php

declare(strict_types=1);

namespace App\Classes\Services\Points;

use App\Repositories\Eloquent\PointRedemptionHistories;
use App\Repositories\Eloquent\RewardPoints;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class UpdatesRewardPointsRedemptionStatus {
    /** @var PointRedemptionHistories */
    private PointRedemptionHistories $pointRedemptionHistories;

    /** @var RewardPoints */
    private RewardPoints $rewardPoints;

    /**
     * UpdatesRewardPointsRedemptionStatus constructor.
     *
     * @param PointRedemptionHistories $pointRedemptionHistories
     * @param RewardPoints             $rewardPoints
     */
    public function __construct(
        PointRedemptionHistories $pointRedemptionHistories,
        RewardPoints $rewardPoints
    ) {
        $this->pointRedemptionHistories = $pointRedemptionHistories;
        $this->rewardPoints             = $rewardPoints;
    }

    /**
     * @param int   $orderId
     * @param float $totalRedeemedPoints
     * @param array $recordIdentifiers
     */
    public function execute(int $orderId, float $totalRedeemedPoints, array $recordIdentifiers): void {
        $pointRedemptionHistory = $this->pointRedemptionHistories->createPointRedemptionHistory($orderId,
            $totalRedeemedPoints);

        foreach ($recordIdentifiers as $index => $recordIdentifier) {
            $rewardPoint    = $this->rewardPoints->findBy('id', $recordIdentifier);
            $redeemedPoints = $rewardPoint->total_points > $totalRedeemedPoints ? $totalRedeemedPoints : $rewardPoint->total_points;
            if ($totalRedeemedPoints > 0) {
                $rewardPoint->update([
                    'redeemed_points'             => $redeemedPoints,
                    'balance_points'              => $rewardPoint->total_points - $redeemedPoints,
                    'point_redemption_history_id' => $pointRedemptionHistory->id
                ]);
            }

            $totalRedeemedPoints = $totalRedeemedPoints - $redeemedPoints;
        }
    }
}
