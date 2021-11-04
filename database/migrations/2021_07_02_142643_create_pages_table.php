<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->text('user_id'); // user_id of our blog post author
            $table->string('slug', 128);
            $table->string('title_en', 256);
            $table->text('body_en');
            $table->string('meta_title_en', 256);
            $table->string('meta_keywords_en', 256);
            $table->string('meta_descriptions_en', 256);
            $table->string('title_de', 256)->nullable();
            $table->text('body_de')->nullable();
            $table->string('meta_title_de', 256)->nullable();
            $table->string('meta_keywords_de', 256)->nullable();
            $table->string('meta_descriptions_de', 256)->nullable();
            $table->string('title_zh', 256)->nullable();
            $table->text('body_zh')->nullable();
            $table->string('meta_title_zh', 256)->nullable();
            $table->string('meta_keywords_zh', 256)->nullable();
            $table->string('meta_descriptions_zh', 256)->nullable();
            $table->string('title_ru', 256)->nullable();
            $table->text('body_ru')->nullable();
            $table->string('meta_title_ru', 256)->nullable();
            $table->string('meta_keywords_ru', 256)->nullable();
            $table->string('meta_descriptions_ru', 256)->nullable();
            $table->string('title_es', 256)->nullable();
            $table->text('body_es')->nullable();
            $table->string('meta_title_es', 256)->nullable();
            $table->string('meta_keywords_es', 256)->nullable();
            $table->string('meta_descriptions_es', 256)->nullable();
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
        Schema::dropIfExists('pages');
    }
}
