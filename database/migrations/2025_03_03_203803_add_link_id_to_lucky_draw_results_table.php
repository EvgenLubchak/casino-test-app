<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkIdToLuckyDrawResultsTable extends Migration
{
    public function up()
    {
        Schema::table('lucky_draw_results', function (Blueprint $table) {
            $table->unsignedBigInteger('link_id')->after('id');
            $table->foreign('link_id')
            ->references('id')
            ->on('temporary_links')
            ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('lucky_draw_results', function (Blueprint $table) {
            $table->dropForeign(['link_id']);
            $table->dropColumn('link_id');
        });
    }
}
