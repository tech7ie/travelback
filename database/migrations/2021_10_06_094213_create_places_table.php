<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title_en', 256);
            $table->text('body_en')->nullable();
            $table->string('title_de', 256)->nullable();
            $table->text('body_de')->nullable();
            $table->string('title_zh', 256)->nullable();
            $table->text('body_zh')->nullable();
            $table->string('title_ru', 256)->nullable();
            $table->text('body_ru')->nullable();
            $table->string('title_es', 256)->nullable();
            $table->text('body_es')->nullable();
            $table->string('url', 256)->nullable();
            $table->string('image', 64)->nullable();
            $table->double('price', 12, 2);
            $table->double('price_per_hour', 12, 2);
            $table->integer('durations');
            $table->integer('extra_durations');
            $table->integer('city_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->enum('status',['enabled', 'disabled'])->default('enabled');
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
        Schema::dropIfExists('places');
    }
}
