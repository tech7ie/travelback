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
            $table->text('title_en');
            $table->text('body_en');
            $table->text('meta_title_en');
            $table->text('meta_keywords_en');
            $table->text('meta_descriptions_en');
            $table->text('title_de');
            $table->text('body_de');
            $table->text('meta_title_de');
            $table->text('meta_keywords_de');
            $table->text('meta_descriptions_de');
            $table->text('title_pl');
            $table->text('body_pl');
            $table->text('meta_title_pl');
            $table->text('meta_keywords_pl');
            $table->text('meta_descriptions_pl');
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
