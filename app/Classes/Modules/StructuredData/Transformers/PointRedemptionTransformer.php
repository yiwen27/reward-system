<?php

declare(strict_types=1);

namespace App\Classes\Modules\StructuredData\Transformers;

use App\Classes\ValueObjects\Points\PointRedemption;
use App\Classes\ValueObjects\Points\PointReward;
use League\Fractal\TransformerAbstract;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class PointRedemptionTransformer extends TransformerAbstract {
    /**
     * @param PointRedemption $pointRedemption
     *
     * @return array
     */
    public function transform(PointRedemption $pointRedemption): array {
        return [
            'points_redeemed'           => $pointRedemption->getRedeemedPoints(),
            'outstanding_amount_in_USD' => $pointRedemption->getOutstandingAmount()
        ];
    }
}
