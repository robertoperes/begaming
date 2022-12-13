<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUserPointHistoryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'user_point_badge_history';

    /**
     * Run the migrations.
     * @table user_point_badge
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('badge_type_id');
            $table->integer('value')->default('0');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('user_id', 'idx_user_point_badge_user_id')
                ->references('id')->on('user')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('badge_type_id', 'idx_user_point_badge_type_id')
                ->references('id')->on('badge_type')
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
