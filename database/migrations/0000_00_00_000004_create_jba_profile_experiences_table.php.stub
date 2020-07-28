<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTableName('experiences'))) {

            Schema::create($this->getTableName('experiences'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('profile_id')->unsigned();
                $table->string('title', 64)->nullable();
                $table->string('type', 32)->nullable();
                $table->string('company', 32)->nullable();
                $table->string('headline', 128)->nullable();
                $table->text('description')->nullable();
                $table->string('location', 128)->nullable();
                $table->boolean('current_employment')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('industry')->nullable();

                $table->foreign('profile_id')
                    ->references('id')
                    ->on($this->getTableName('profiles'))
                    ->onDelete('cascade');
            });
        }
        else {
            dump('Ignore' . __FILE__ . ' as ' . $this->getTableName('experiences') . ' table has exists');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('experiences'));
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
