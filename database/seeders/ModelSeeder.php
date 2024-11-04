<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    public function run()
    {
        // Step 1: Truncate the table
        \DB::table('models')->truncate();

        // Step 2: Seed data
        \DB::table('models')->insert([
            [
                'name' => 'الصلاحيات',
                'name_en' => 'roles',
            ],
            [
                'name' => 'الاعدادات',
                'name_en' => 'settings',
            ],
            [
                'name' => 'الطلبات',
                'name_en' => 'orders',
            ],
            [
                'name' => 'التقارير',
                'name_en' => 'reports',
            ],
            [
                'name' => 'حملات واتساب',
                'name_en' => 'campaigns',
            ],
            [
                'name' => 'المشاريع',
                'name_en' => 'projects',
            ],
            [
                'name' => 'الأقسام',
                'name_en' => 'categories',
            ],
            [
                'name' => 'المقالات',
                'name_en' => 'blogs',
            ],

        ]);
    }
}
