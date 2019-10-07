<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTableName('resumes'))) {

            Schema::create($this->getTableName('resumes'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('profile_id')->unsigned();
                $table->string('file_name', 64)->nullable();
                $table->string('file_type', 32)->nullable();
                $table->integer('file_size')->nullable();
                $table->string('file_path', 128)->nullable();
                $table->timestamps();

                $table->foreign('profile_id')
                    ->references('id')
                    ->on($this->getTableName('profiles'))
                    ->onDelete('cascade');
            });
        }
        else {
            dump('Ignore' . __FILE__ . ' as ' . $this->getTableName('resumes') . ' table has exists');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('resumes'));
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
