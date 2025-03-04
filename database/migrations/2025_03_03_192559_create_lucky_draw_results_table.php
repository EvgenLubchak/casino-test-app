<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuckyDrawResultsTable extends Migration
{
    public function up()
    {
        Schema::create('lucky_draw_results', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('result');
            $table->decimal('prize', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lucky_draw_results');
    }
}
