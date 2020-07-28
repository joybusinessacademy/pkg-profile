<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTableName('educations'))) {

            Schema::create($this->getTableName('educations'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('profile_id')->unsigned();
                $table->string('school', 64)->nullable();
                $table->string('degree', 32)->nullable();
                $table->string('major', 32)->nullable();
                $table->year('start_year')->nullable();
                $table->year('end_year')->nullable();
                $table->string('grade', 32)->nullable();
                $table->text('activities_and_societies')->nullable();
                $table->text('description')->nullable();

                $table->foreign('profile_id')
                    ->references('id')
                    ->on($this->getTableName('profiles'))
                    ->onDelete('cascade');
            });
        }
        else {
            dump('Ignore' . __FILE__ . ' as ' . $this->getTableName('educations') . ' table has exists');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('educations'));
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
