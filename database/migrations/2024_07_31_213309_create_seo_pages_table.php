<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_name');
            $table->timestamps();
        });

        Schema::create('seo_page_translations', function (Blueprint $table) {
            $table->id();
            $table->string('meta_name');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->string('locale')->index();
            $table->foreignId('seo_page_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['seo_page_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('seo_pages');
        Schema::dropIfExists('seo_page_translations');
    }
}
