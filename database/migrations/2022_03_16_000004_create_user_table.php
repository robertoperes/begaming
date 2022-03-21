<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'user';

    /**
     * Run the migrations.
     * @table user
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->tinyInteger('admin')->default('0');
            $table->string('name');
            $table->string('email');
            $table->tinyInteger('active')->default('1');
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password');
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->rememberToken();
            $table->date('admission_date')->nullable();
            $table->string('google_id')->nullable()->default(null);
            $table->string('google_avatar', 255);
            $table->unique(["email"], 'users_email_unique');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

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
