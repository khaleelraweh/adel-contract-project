<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentTemplate;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $dts = DocumentTemplate::query()->pluck('id');

        Document::create([
            'doc_no'            => $faker->numberBetween(0, 10),
            'doc_name'          =>  ['ar'   =>  'وثيقة باسم العميل 1', 'en'  =>  'Document named by Customer 1'],
            'doc_content'           =>  ['ar'   =>  'بيانات', 'en'  =>  'Data'],
            'doc_file'          =>  '1.pdf',
            'document_template_id'          =>  $dts->random(),
            'doc_status'            =>  1,
            'published_on'          =>  $faker->dateTime(),
            'created_by'            =>  $faker->name(),
            'created_at'            =>  $faker->dateTime(),
        ]);

        Document::create([
            'doc_no'            => $faker->numberBetween(0, 10),
            'doc_name'          =>  ['ar'   =>  'وثيقة باسم العميل 2', 'en'  =>  'Document named by Customer 2'],
            'doc_content'           =>  ['ar'   =>  'بيانات', 'en'  =>  'Data'],
            'doc_file'          =>  '2.pdf',
            'document_template_id'          =>  $dts->random(),
            'doc_status'            =>  0,
            'published_on'          =>  $faker->dateTime(),
            'created_by'            =>  $faker->name(),
            'created_at'            =>  $faker->dateTime(),
        ]);
    }
}
