<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBadgeTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'badge';

    /**
     * Run the migrations.
     * @table badge
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->tinyInteger('active')->default('1');
            $table->string('icon', 100)->nullable();
            $table->unsignedInteger('badge_type_id');
            $table->unsignedInteger('badge_classification_id');
            $table->integer('value')->default('0');

            $table->index(["badge_type_id"], 'idx_badge_badge_type_id');

            $table->index(["badge_classification_id"], 'idx_badge_badge_classification_id');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('badge_type_id', 'idx_badge_badge_type_id')
                ->references('id')->on('badge_type')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('badge_classification_id', 'idx_badge_badge_classification_id')
                ->references('id')->on('badge_classification')
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
