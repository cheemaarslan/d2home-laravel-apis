<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryManWeeklyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('delivery_man_weekly_reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('delivery_man_id');
        $table->string('week_identifier');
        $table->json('order_ids');
        $table->decimal('total_price', 10, 2);
        $table->integer('orders_count');
        $table->decimal('total_commission', 10, 2);
        $table->decimal('total_discounts', 10, 2);
<<<<<<< HEAD
        $table->string('status')->nullable(); // Optional: status of the report
=======
>>>>>>> ce60b242eade5f4b082f654f90b5e5eca4ce4dd9
        $table->timestamps();

        $table->foreign('delivery_man_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_man_weekly_reports');
    }
}
