<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_variables', function (Blueprint $table) {

            $table->id();
            $table->string('cv_name')->nullable();
            $table->string('cv_question')->nullable();
            $table->string('cv_type')->nullable();  // 0 means text , 1 means number
            $table->boolean('cv_required')->nullable()->default(true); // 0 mean no // 1 mean yes 
            $table->string('cv_details')->nullable();
            $table->string('cv_code')->nullable();
            $table->foreignId('contract_template_id')->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('contract_variables');
    }
};
