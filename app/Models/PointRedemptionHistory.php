<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
final class PointRedemptionHistory extends Model {
    public $incrementing = true;

    protected $table = 'point_redemption_histories';

    protected $fillable = [
        'order_id',
        'redeemed_points'
    ];

    protected $casts = [
        'redeemed_points' => 'float',
    ];
}
