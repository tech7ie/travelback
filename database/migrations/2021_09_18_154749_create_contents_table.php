<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('label_en', 128);
            $table->text('body_en')->nullable();
            $table->string('url_en', 128)->nullable();
            $table->string('image_en', 128)->nullable();
            $table->string('label_de', 128)->nullable();
            $table->text('body_de')->nullable();
            $table->string('url_de', 128)->nullable();
            $table->string('image_de', 128)->nullable();
            $table->string('label_zh', 128)->nullable();
            $table->text('body_zh')->nullable();
            $table->string('url_zh', 128)->nullable();
            $table->string('image_zh', 128)->nullable();
            $table->string('label_ru', 128)->nullable();
            $table->text('body_ru')->nullable();
            $table->string('url_ru', 128)->nullable();
            $table->string('image_ru', 128)->nullable();
            $table->string('label_es', 128)->nullable();
            $table->text('body_es')->nullable();
            $table->string('url_es', 128)->nullable();
            $table->string('image_es', 128)->nullable();
            $table->enum('type',['social', 'let_us_know', 'helpdesk']);
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
        Schema::dropIfExists('contents');
    }
}
