<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('portfolio_category_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->foreignId('portfolio_category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->longText('description')->nullable();

            $table->unique(['portfolio_category_id', 'locale']);
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
        Schema::dropIfExists('portfolio_categories');
        Schema::dropIfExists('portfolio_category_translations');
    }
}