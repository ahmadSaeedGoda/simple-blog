<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('categories')) {
            return;
        } else {
            Schema::connection(env('MYSQL_DB_CONNECTION'))
                ->create('categories', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->bigIncrements('id');
                    $table->string('name')->unique();
                    $table->string('slug')->unique();
                    $table->timestamps();
                    $table->softDeletes();
                });
        }
        Artisan::call('db:seed', [
            '--class' => CategoriesTableSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
