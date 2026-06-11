<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPaperPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_paper_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_paper_id');
            $table->string('title');
            $table->string('image');
            $table->longText('map_data_json')->nullable();
            $table->longText('map_data_area')->nullable();
            $table->timestamps();

            $table->foreign('news_paper_id')->references('id')->on('news_papers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_paper_pages');
    }
}
