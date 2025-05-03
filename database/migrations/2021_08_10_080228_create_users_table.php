<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 100)->unique()->nullable(false);
            $table->string('password', 100)->nullable(true);
            $table->timestamp('last_login')->nullable(true);
            $table->tinyInteger('active')->default(1)->nullable(true);
            $table->timestamp('email_verified_at')->nullable(true);
            $table->longText('tfa_secret')->nullable(true);
            $table->boolean('tfa_notified')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
