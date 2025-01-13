<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\ContractTemplate;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $dts = ContractTemplate::query()->pluck('id');

        Contract::create([
            'contract_no'            => $faker->numberBetween(0, 10),
            'contract_name'          =>  ['ar'   =>  'عقد باسم العميل 1', 'en'  =>  'contract named by Customer 1'],
            'contract_content'           =>  ['ar'   =>  'بيانات', 'en'  =>  'Data'],
            'contract_file'          =>  '1.pdf',
            'contract_template_id'          =>  $dts->random(),
            'contract_status'            =>  1,
            'published_on'          =>  $faker->dateTime(),
            'created_by'            =>  $faker->name(),
            'created_at'            =>  $faker->dateTime(),
        ]);

        Contract::create([
            'contract_no'            => $faker->numberBetween(0, 10),
            'contract_name'          =>  ['ar'   =>  'وثيقة باسم العميل 2', 'en'  =>  'Document named by Customer 2'],
            'contract_content'           =>  ['ar'   =>  'بيانات', 'en'  =>  'Data'],
            'contract_file'          =>  '2.pdf',
            'contract_template_id'          =>  $dts->random(),
            'contract_status'            =>  0,
            'published_on'          =>  $faker->dateTime(),
            'created_by'            =>  $faker->name(),
            'created_at'            =>  $faker->dateTime(),
        ]);
    }
}
