<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPaperPageFramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_paper_page_frames', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_paper_page_id');
            $table->string('unique_id');
            $table->string('title')->nullable();
            $table->longText('details')->nullable();
            $table->string('image');
            $table->timestamps();

            $table->foreign('news_paper_page_id')->references('id')->on('news_paper_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_paper_page_frames');
    }
}
