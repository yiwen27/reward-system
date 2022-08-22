<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
final class Order extends Model {
    public $incrementing = true;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'currency',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'float',
    ];
}
