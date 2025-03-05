<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique('roles_name_unique'); // Drop the unique constraint
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unique('name'); // Re-add the unique constraint if rolling back
        });
    }

};
