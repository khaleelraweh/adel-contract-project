<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use App\Models\DocumentType;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
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

        // Loop through documentcategories 
        $documentDatas = [

            [
                'doc_type_name' => ['ar' => 'إستمارة اشتراك', 'en' => 'Subscription form'],
                'doc_type_note' => ['ar' => 'وصف إستمارة اشتراك', 'en' => 'Description of subscription form'],
                'document_category_id' => $document_categories->random(), // Random category
            ],
            [
                'doc_type_name' => ['ar' => 'إستمارة فتح حساب', 'en' => 'Account opening form'],
                'doc_type_note' => ['ar' => 'وصف إستمارة فتح حساب', 'en' => 'Description of account opening form'],
                'document_category_id' => $document_categories->random(), // Random category
            ],
            [
                'doc_type_name' => ['ar' => 'إستمارة إيقاف حساب', 'en' => 'Account suspension form'],
                'doc_type_note' => ['ar' => 'وصف إستمارة إيقاف حساب', 'en' => 'Description of account suspension form'],
                'document_category_id' => $document_categories->random(), // Random category
            ],

        ];

        // Loop through each course data and create courses
        foreach ($documentDatas as $documentData) {

            $documentType = DocumentType::create([
                'doc_type_name' => $documentData['doc_type_name'],
                'doc_type_note' => $documentData['doc_type_note'],
                'document_category_id'  =>  $documentData['document_category_id'],
                'created_by' => 'Admin System',
                'status' => true,
                'published_on' => $faker->dateTime(),
            ]);
        }
    }
}
