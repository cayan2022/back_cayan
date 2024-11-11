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
                'name' => 'الادوار والصلاحيات',
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
                'name' => 'من نحن',
                'name_en' => 'abouts',
            ],
            [
                'name' => 'الصفحات',
                'name_en' => 'pages',
            ],

            [
                'name' => 'المقالات',
                'name_en' => 'blogs',
            ],
            [
                'name' => 'الخدمات',
                'name_en' => 'services',
            ],
            [
                'name' => 'الشهادات',
                'name_en' => 'testimonials',
            ],
            [
                'name' => 'العروض',
                'name_en' => 'offers',
            ],
            [
                'name' => 'الاخبار',
                'name_en' => 'tidings',
            ],
            [
                'name' => 'الملف الشخصي',
                'name_en' => 'profiles',
            ],
            [
                'name' => 'المصادر',
                'name_en' => 'sources',
            ],
            [
                'name' => 'الفروع',
                'name_en' => 'branches',
            ],
            [
                'name' => 'شركاء النجاح',
                'name_en' => 'partners',
            ],
            [
                'name' => 'الموظفين',
                'name_en' => 'doctors',
            ],
            [
                'name' => 'صحفات محرك البحث',
                'name_en' => 'seoPages',
            ],
            [
                'name' => 'العملاء',
                'name_en' => 'customers',
            ],
            [
                'name' => 'اقسام المحافظ',
                'name_en' => 'portfolio-categories',
            ],[
                'name' => 'المحافظ',
                'name_en' => 'portfolios',
            ],
            [
                'name' => 'سجل النشاط',
                'name_en' => 'activity_logs',
            ]
        ]);
    }
}
