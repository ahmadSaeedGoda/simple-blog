<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('comments')) {
            return;
        } else {
            Schema::connection(env('MYSQL_DB_CONNECTION'))
                ->create('comments', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('article_id')->unsigned();
                    $table->bigInteger('user_id')->unsigned();
                    $table->text('comment');
                    $table->foreign('article_id')
                        ->references('id')->on('articles')
                        ->onDelete('cascade');
                    $table->foreign('user_id')
                        ->references('id')->on('users')
                        ->onDelete('cascade');
                    $table->timestamps();
                    $table->softDeletes();
                });
        }
        Artisan::call('db:seed', [
            '--class' => CommentsTableSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
