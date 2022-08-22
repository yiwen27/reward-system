<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\PointRedemptionHistory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class PointRedemptionHistories extends BaseRepository {
    public function model(): string {
        return PointRedemptionHistory::class;
    }

    /**
     * @param int   $orderId
     * @param float $redeemedPoints
     *
     * @return Model
     */
    public function createPointRedemptionHistory(
        int $orderId,
        float $redeemedPoints
    ): Model {
        return $this->model->create([
            'order_id'        => $orderId,
            'redeemed_points' => $redeemedPoints
        ]);
    }
}
