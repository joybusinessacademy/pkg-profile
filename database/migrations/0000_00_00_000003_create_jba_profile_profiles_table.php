<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName('profiles'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('first_name', 64)->nullable();
            $table->string('last_name', 64)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('gender', 16)->nullable();
            $table->string('avatar', 128)->nullable();
            //    $table->string('msd_number')->nullable();
            $table->string('location', 256)->nullable();
            $table->bigInteger('region_id')->unsigned()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('ethnicity', 32)->nullable();
            $table->string('residency', 32)->nullable();
            $table->boolean('employment_status')->nullable();
            $table->timestamps();

            /*$table->foreign('user_id')
                ->references('id')
                ->on($this->getTableName('users'))
                ->onDelete('cascade');*/

            $table->foreign('region_id')
                ->references('id')
                ->on($this->getTableName('regions'))
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
        Schema::dropIfExists($this->getTableName('profiles'));
    }

    protected function getTableName($table)
    {
        $tables = config('jba-profile.table_names');

        if(isset($tables[$table])) {
            return $tables[$table];
        }

        throw new \ErrorException('Invalid table name in ' . __FUNCTION__);
    }
}
