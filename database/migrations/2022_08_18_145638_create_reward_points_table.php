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
            $table->integer('order_id')->comment('Foreign key of orders table');
            $table->decimal('total_points', 10, 2);
            $table->decimal('redeemed_points', 10, 2);
            $table->decimal('balance_points', 10, 2);
            $table->dateTime('expiry_date');
            $table->integer('point_redemption_history_id')->nullable()
                  ->comment('Foreign key of point_redemption_histories table');
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
