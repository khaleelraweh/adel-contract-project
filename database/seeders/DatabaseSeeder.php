<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(SiteSettingSeeder::class);
        $this->call(EntrustSeeder::class);

        $this->call(DocumentCategorySeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(DocumentTemplateSeeder::class);
        $this->call(DocumentSeeder::class);

        $this->call(ContractTemplateSeeder::class);
        $this->call(ContractSeeder::class);
    }
}
