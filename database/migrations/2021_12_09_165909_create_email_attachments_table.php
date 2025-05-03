<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('email_notification_id')->unsigned()->nullable(false);
            $table->foreign('email_notification_id')->references('id')->on('email_notifications')->onUpdate('cascade');
            $table->string('file_name', 100)->nullable(false);
            $table->longText('content')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
