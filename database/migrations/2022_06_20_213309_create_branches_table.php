<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('address');
            $table->string('phone');
            $table->string('whatsapp_phone');
            $table->string('map_link');
            $table->boolean('is_active');
            $table->timestamps();
        });

        Schema::create('branch_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('short_description');
            $table->longText('description');
            $table->string('locale')->index();
            $table->unique(['branch_id', 'locale']);
            $table->foreignId('branch_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('branches');
        Schema::dropIfExists('branch_translations');
    }
}
