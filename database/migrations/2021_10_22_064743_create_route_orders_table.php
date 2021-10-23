<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('route_id')->nullable();
            $table->string('email', 64);
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('phone', 64);
            $table->text('comment');
            $table->string('pickup_address', 256);
            $table->string('drop_off_address', 256);
            $table->integer('adults');
            $table->integer('childrens');
            $table->integer('luggage');
            $table->integer('payment_type')->default(1);
            $table->double('amount', 12, 2);
            $table->string('currency', 3);
            $table->timestamp('route_date')->useCurrent()->nullable();
            $table->enum('status',['pending', 'complete', 'fail'])->default('pending');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_orders');
    }
}
