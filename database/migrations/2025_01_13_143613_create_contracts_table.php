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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_no');
            $table->json('contract_name');
            $table->json('slug');
            $table->json('contract_content')->nullable();
            $table->string('contract_file')->nullable();
            $table->foreignId('contract_template_id')->constrained()->cascadeOnDelete();

            $table->tinyInteger('contract_type')->nullable()->default(0); // داخلي 0  خارجي 1

            $table->tinyInteger('contract_status')->nullable()->default(0); // مسودة 0  مكتملة 1

            // will be use always
            $table->boolean('status')->nullable()->default(false);
            $table->dateTime('published_on')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // end of will be use always
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
