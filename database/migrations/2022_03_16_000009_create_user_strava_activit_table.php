<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUserStravaActivitTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'user_strava_activit';

    /**
     * Run the migrations.
     * @table user_strava_activities
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_strava_id');
            $table->tinyInteger('active')->default('1');
            $table->string('name', 100);
            $table->string('type', 45);
            $table->dateTime('start_date_local');
            $table->integer('elapsed_time')->nullable();
            $table->text('description')->nullable();

            $table->index(["user_strava_id"], 'idx_user_strava_activit_user_strava_id');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('user_strava_id', 'idx_user_strava_activit_user_strava_id')
                ->references('id')->on('user_strava')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
