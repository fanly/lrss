<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('author', 50);
            $table->string('type', 30);
            $table->text('content');
            $table->string('url', 150);
            $table->string('imageUrl', 150);
            $table->string('published', 100);

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
        Schema::dropIfExists('rss_datas');
    }
}
