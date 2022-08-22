<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
final class Customer extends Model {
    public $incrementing = true;

    protected $table = 'customers';

    protected $fillable = [
        'customers',
        'first_name',
        'last_name',
        'email',
        'mobile_number'
    ];

    protected $casts = [];
}
