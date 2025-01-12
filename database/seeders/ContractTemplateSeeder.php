<?php

namespace Database\Seeders;

use App\Models\ContractTemplate;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        ContractTemplate::create([
            'contract_template_name'              =>  ['ar'   =>  'عقد باسم العميل 1', 'en'  =>  'Contract named by Customer 1'],
            'contract_text'              =>  ['ar'   =>  $faker->text(), 'en'  =>  $faker->text()],
            'contract_template_file'              =>  '1.pdf',
            'created_by'        => 'Admin System',
            'status'            => true,
            'published_on'      => $faker->dateTime(),
        ]);

        ContractTemplate::create([
            'contract_template_name'              =>  ['ar'   =>  'عقد باسم العميل 2', 'en'  =>  'Contract named by Customer 2'],
            'contract_text'              =>  ['ar'   =>  $faker->text(), 'en'  =>  $faker->text()],
            'contract_template_file'              =>  '2.pdf',
            'created_by'        => 'Admin System',
            'status'            => true,
            'published_on'      => $faker->dateTime(),
        ]);
    }
}
