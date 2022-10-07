<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message_id');

            $table->string('from')->nullable();
            $table->text('to')->nullable();
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();

            $table->string('subject')->nullable();
            $table->text('body');

            $table->string('status')->nullable();
            $table->string('severity')->nullable();
            $table->string('reason')->nullable();
            $table->text('description')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }
}
