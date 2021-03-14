<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->string('id');
            $table->json('fileTags');
            $table->integer('downloads');
            $table->string('fileName');
            $table->string('userId');
            $table->string('types');
            $table->integer('size');
            $table->string('fileOriginName');
            $table->string('userName');
            $table->string('createdAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
