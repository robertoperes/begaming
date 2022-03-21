<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUserBadgeTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'user_badge';

    /**
     * Run the migrations.
     * @table user_badge
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('badge_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();

            $table->index(["badge_id"], 'idx_user_badge_badge_id');

            $table->index(["user_id"], 'idx_user_badge_user_id');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('badge_id', 'idx_user_badge_badge_id')
                ->references('id')->on('badge')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'idx_user_badge_user_id')
                ->references('id')->on('user')
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
