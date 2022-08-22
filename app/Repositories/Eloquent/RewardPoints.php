<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Classes\ValueObjects\Points\PointReward;
use App\Models\RewardPoint;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class RewardPoints extends BaseRepository {
    public function model(): string {
        return RewardPoint::class;
    }

    /**
     * @param int $customerId
     *
     * @return Collection
     */
    public function getAvailableRewardPointsByCustomerId(int $customerId): Collection {
        return $this->model->where('customer_id', '=', $customerId)
                           ->where('expiry_date', '>', Carbon::now()->toDateTimeString())
                           ->whereNull('point_redemption_history_id')->get();
    }

    /**
     * @param PointReward $pointReward
     *
     * @return Model
     */
    public function createRewardPointsTransaction(PointReward $pointReward): Model {
        return $this->model->create([
            'customer_id'     => $pointReward->getCustomerId(),
            'order_id'        => $pointReward->getOrderId(),
            'expiry_date'     => $pointReward->getExpiryDate(),
            'total_points'    => $pointReward->getTotalPoints(),
            'redeemed_points' => 0,
            'balance_points'  => $pointReward->getTotalPoints()
        ]);
    }
}
