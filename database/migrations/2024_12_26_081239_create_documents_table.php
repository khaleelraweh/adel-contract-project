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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_no');
            $table->json('doc_name');
            $table->json('slug');
            $table->json('doc_content')->nullable();
            $table->string('doc_file')->nullable();
            $table->foreignId('document_template_id')->constrained()->cascadeOnDelete();

            $table->tinyInteger('doc_type')->nullable()->default(0); // داخلي 0  خارجي 1

            $table->tinyInteger('doc_status')->nullable()->default(0); // مسودة 0  مكتملة 1

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
        Schema::dropIfExists('documents');
    }
};
