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
            'name'              =>  ['ar'   =>  'عقد باسم العميل 1', 'en'  =>  'Contract named by Customer 1'],
            'text'              =>  ['ar'   =>  $faker->text(), 'en'  =>  $faker->text()],
            'file'              =>  '1.pdf',
            'created_by'        => 'Admin System',
            'status'            => true,
            'published_on'      => $faker->dateTime(),
        ]);

        ContractTemplate::create([
            'name'              =>  ['ar'   =>  'عقد باسم العميل 2', 'en'  =>  'Contract named by Customer 2'],
            'text'              =>  ['ar'   =>  $faker->text(), 'en'  =>  $faker->text()],
            'file'              =>  '2.pdf',
            'created_by'        => 'Admin System',
            'status'            => true,
            'published_on'      => $faker->dateTime(),
        ]);
    }
}
