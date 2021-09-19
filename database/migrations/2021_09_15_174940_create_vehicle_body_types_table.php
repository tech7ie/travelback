<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleBodyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_body_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->dropColumn('image');
            $table->string('image', 128)->nullable();
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
        Schema::dropIfExists('vehicle_body_types');
    }
}
