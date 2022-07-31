<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->boolean('is_active');
            $table->timestamps();
        });

        Schema::create('source_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('short_description');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['source_id', 'locale']);
            $table->foreignId('source_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('sources');
        Schema::dropIfExists('source_translations');
    }
}
