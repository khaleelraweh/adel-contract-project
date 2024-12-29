<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $categories = [
            [
                'doc_cat_name' => ['ar' => 'عقود', 'en' => 'Contracts'],
                'doc_cat_note' => ['ar' => 'عقود مخصصة', 'en' => 'Custom contracts'],
            ],
            [
                'doc_cat_name' => ['ar' => 'إستمارات', 'en' => 'Forms'],
                'doc_cat_note' => ['ar' => 'إستمارات مخصصة', 'en' => 'Custom forms'],
            ],

        ];

        foreach ($categories as $category) {
            DocumentCategory::create([
                'doc_cat_name' => $category['doc_cat_name'],
                'doc_cat_note' => $category['doc_cat_note'],
                'created_by' => 'Admin System',
                'status' => true,
                'published_on' => $faker->dateTime(),
            ]);
        }
    }
}
