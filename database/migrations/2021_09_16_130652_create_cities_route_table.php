<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities_route', function (Blueprint $table) {
            $table->id();
            $table->integer('route_id')->nullable();
            $table->integer('cities_id')->nullable();
            $table->string('label', 128)->nullable();
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
        Schema::dropIfExists('city_route');
    }
}
