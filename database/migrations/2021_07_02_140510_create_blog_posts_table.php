<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            /* We started adding code here*/

            $table->text('title');  // Title of our blog post
            $table->text('body');   // Body of our blog post
            $table->text('user_id'); // user_id of our blog post author
            $table->text('lang'); // user_id of our blog post author
            $table->text('slug'); // user_id of our blog post author
            $table->text('meta_title'); // user_id of our blog post author
            $table->text('meta_descriptions'); // user_id of our blog post author

            /* We stopped adding code here*/


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
