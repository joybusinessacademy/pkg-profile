<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')) {

            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 64);
                $table->string('email', 128)->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 64);
                $table->rememberToken();
                $table->timestamps();
            });
        }
        else {
            dump('Ignore' . __FILE__ . ' as users table has exists');
        }
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
