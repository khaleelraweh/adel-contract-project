<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $document_categories = DocumentCategory::active()->pluck('id');
        $document_types = DocumentType::active()->pluck('id');


        // Loop through documentcategories 
        $documentDatas = [

            [
                'doc_template_name' => ['ar' => 'نموذج عقد شراكة', 'en' => 'Partnership contract form'],
                'document_category_id' => $document_categories->random(), // Random category
                'document_type_id' => $document_types->random(), // Random type
            ],
            [
                'doc_template_name' => ['ar' => 'نموذج عقد عمل', 'en' => 'Employment contract template'],
                'document_category_id' => $document_categories->random(), // Random category
                'document_type_id' => $document_types->random(), // Random type
            ],



        ];

        // Loop through each course data and create courses
        foreach ($documentDatas as $documentData) {

            $documentTemplate = DocumentTemplate::create([
                'doc_template_name' => $documentData['doc_template_name'],
                'document_category_id'  =>  $documentData['document_category_id'],
                'document_type_id'  =>  $documentData['document_type_id'],
                'created_by' => 'Admin System',
                'status' => true,
                'published_on' => $faker->dateTime(),
            ]);
        }
    }
}
