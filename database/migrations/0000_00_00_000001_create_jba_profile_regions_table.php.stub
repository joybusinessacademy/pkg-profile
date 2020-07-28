<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJbaProfileRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTableName('regions'))) {
            Schema::create($this->getTableName('regions'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('parent_id')->unsigned()->nullable();
                $table->string('name', 32);

                $table->foreign('parent_id')
                    ->references('id')
                    ->on($this->getTableName('regions'))
                    ->onDelete('cascade');
            });
        }
        else {
            dump('Ignore' . __FILE__ . ' as ' . $this->getTableName('regions') . ' table has exists');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('regions'));
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
