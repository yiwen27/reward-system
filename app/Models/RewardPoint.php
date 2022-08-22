<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
final class RewardPoint extends Model {
    public $incrementing = true;

    protected $table = 'reward_points';

    protected $fillable = [
        'customer_id',
        'order_id',
        'total_points',
        'redeemed_points',
        'balance_points',
        'expiry_date',
        'point_redemption_history_id'
    ];

    protected $casts = [
        'total_points'    => 'float',
        'redeemed_points' => 'float',
        'balance_points'  => 'float',
    ];
}
