<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('articles')) {
            return;
        } else {
            Schema::connection(env('MYSQL_DB_CONNECTION'))
                ->create('articles', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->bigIncrements('id');
                    $table->bigInteger('category_id')->unsigned();
                    $table->string('title')->unique();
                    $table->string('slug')->unique();
                    $table->text('body');
                    $table->boolean('is_published')->default(false);
                    $table->foreign('category_id')
                        ->references('id')->on('categories')
                        ->onDelete('cascade');
                    $table->timestamps();
                    $table->softDeletes();
                });
        }
        Artisan::call('db:seed', [
            '--class' => ArticlesTableSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
