<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->text('body');
            $table->integer('user_id');
            $table->integer('route_from_city_id')->nullable();
            $table->integer('route_from_country_id')->nullable();
            $table->integer('route_to_city_id')->nullable();
            $table->integer('route_to_country_id')->nullable();
            $table->double('price', 12, 2);
            $table->string('cars', 64);
            $table->string('image', 64);
            $table->enum('status',['open', 'closed', 'done', 'fail']);
            $table->timestamp('route_start');
            $table->timestamp('route_end')->nullable();
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
        Schema::dropIfExists('routes');
    }
}
