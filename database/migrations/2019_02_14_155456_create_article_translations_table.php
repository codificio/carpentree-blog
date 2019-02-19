<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');

            $table->string('slug')->unique();
            $table->string('title');
            $table->text('body')->nullable();
            $table->text('excerpt')->nullable();

            $table->string('locale')->index();

            $table->unique(['article_id','locale']);

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_translations');
    }
}
