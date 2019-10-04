<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTableName('references'))) {

            Schema::create($this->getTableName('references'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('profile_id')->unsigned();
                $table->string('referrer', 64)->nullable();
                $table->string('company', 32)->nullable();
                $table->string('job_title', 32)->nullable();
                $table->string('phone', 32)->nullable();
                $table->string('email', 64)->nullable();
                $table->text('description')->nullable();

                $table->foreign('profile_id')
                    ->references('id')
                    ->on($this->getTableName('profiles'))
                    ->onDelete('cascade');
            });
        }
        else {
            dump('Ignore' . __FILE__ . ' as ' . $this->getTableName('references') . ' table has exists');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('references'));
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
