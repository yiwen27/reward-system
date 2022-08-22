<?php

declare(strict_types=1);

namespace App\Classes\Modules\StructuredData\Transformers;

use App\Models\RewardPoint;
use League\Fractal\TransformerAbstract;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class PointRewardTransformer extends TransformerAbstract {
    /**
     * @param RewardPoint $rewardPoint
     *
     * @return array
     */
    public function transform(RewardPoint $rewardPoint): array {
        return [
            'id'                          => $rewardPoint->id,
            'customer_id'                 => $rewardPoint->customer_id,
            'order_id'                    => $rewardPoint->order_id,
            'total_points'                => $rewardPoint->total_points,
            'redeemed_points'             => $rewardPoint->redeemed_points,
            'balance_points'              => $rewardPoint->balance_points,
            'expiry_date'                 => $rewardPoint->expiry_date,
            'point_redemption_history_id' => $rewardPoint->point_redemption_history_id,
            'created_at'                  => $rewardPoint->created_at,
            'updated_at'                  => $rewardPoint->updated_at
        ];
    }
}
