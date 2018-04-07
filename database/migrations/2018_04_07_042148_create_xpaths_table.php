<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXpathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xpaths', function (Blueprint $table) {
            $table->increments('id');

            // title
            $table->string('titlexpath', 250);
            $table->string('titlevalue', 100);

            // desc
            $table->string('descxpath', 250);
            $table->string('descvalue', 100);

            // url
            $table->string('urlxpath', 250);
            $table->string('urlvalue', 100);
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
        Schema::dropIfExists('xpaths');
    }
}
