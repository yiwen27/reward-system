<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class Customers extends BaseRepository {
    public function model(): string {
        return Customer::class;
    }

    /**
     * @return Collection
     */
    public function getExpiredRedPackets(): Collection {
        return $this->model->where('is_received', '=', false)->where('receiver_id', '=', null)
                           ->where('is_expired', '=', false)
                           ->where('created_at', '<=', Carbon::now()->sub(CarbonInterval::day())->toDateTimeString())
                           ->get();
    }
}
