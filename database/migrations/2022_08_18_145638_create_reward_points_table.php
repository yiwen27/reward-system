<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class CreateRewardPointsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('reward_points', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->comment('Foreign key of customers table');
            $table->integer('order_header_id')->comment('Foreign key of order_headers table');
            $table->float('total_points');
            $table->float('redeemed_points');
            $table->float('balance_points');
            $table->dateTime('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('reward_points');
    }
}
