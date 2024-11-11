<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageToUserTenantTable extends Migration
{
    public function up()
    {
        Schema::table('user_tenants', function (Blueprint $table) {
            $table->foreignId('package_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('active_models')->nullable();
            $table->json('templates')->nullable();
            $table->foreignId('template_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('active_template')->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_tenants', function (Blueprint $table) {
            $table->dropColumn(['package_id', 'active_models', 'templates','template_id', 'active_template']);
        });
    }
}
