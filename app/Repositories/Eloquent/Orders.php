<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\BaseRepository;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class Orders extends BaseRepository {
    public function model(): string {
        return Order::class;
    }
}
