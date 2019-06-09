<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            return;
        } else {
            Schema::connection(env('MYSQL_DB_CONNECTION'))
                ->create('users', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->bigIncrements('id');
                    $table->boolean('is_admin')->default(false);
                    $table->string('first_name');
                    $table->string('last_name');
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->timestamp('last_login_at')->nullable();
                    $table->rememberToken();
                    $table->timestamps();
                    $table->softDeletes();
                });
        }
        Artisan::call('db:seed', [
            '--class' => UsersTableSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
