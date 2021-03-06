<?php

namespace App\Database;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('password_resets')) {
            return;
        }
        Schema::connection(env('MYSQL_DB_CONNECTION'))
            ->create('password_resets', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('email')->index();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
                $table->softDeletes();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
