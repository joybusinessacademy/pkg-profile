<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJbaProfileProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->getTableName('profiles'), function (Blueprint $table) {
            $table->text('personal_summary')->after('avatar')->nullable();
            $table->integer('employment_status')->change();
            //$table->integer('job_seeker_benefit')->after('msd_number')->nullable();
            $table->text('skills')->after('personal_summary')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->getTableName('profiles'), function (Blueprint $table) {
            $table->dropColumn('personal_summary');
            $table->boolean('employment_status')->change();
            $table->dropColumn('skills');
        });
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
