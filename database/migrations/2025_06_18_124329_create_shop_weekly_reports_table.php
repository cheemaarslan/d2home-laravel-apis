<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopWeeklyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_weekly_reports', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('shop_id');
    $table->string('week_identifier'); 
    $table->json('order_ids');
    $table->decimal('total_price', 10, 2)->default(0);
    $table->integer('orders_count')->default(0);
    $table->decimal('total_commission', 10, 2)->default(0);
    $table->decimal('total_discounts', 10, 2)->default(0);
    $table->timestamps();
    $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
    $table->unique(['shop_id', 'week_identifier']);
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_weekly_reports');
    }
}
