<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('phone')->unique();
            $table->enum('type', User::TYPES);
            $table->enum('gender', User::GENDERS);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_block')->default(false);
            $table->rememberToken();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
