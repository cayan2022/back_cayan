<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * @var Repository|Application|mixed
     */
    private $count;

    public function __construct()
    {
        $this->count = config('database.seeder_count');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(
            [
                'ar' => ['name' => 'جديد'],
                'en' => ['name' => 'New']
            ]
        );
        Status::create(
            [
                'ar' => ['name' => 'متابعة'],
                'en' => ['name' => 'Following']
            ]
        );
        Status::create(
            [
                'ar' => ['name' => 'تم الدفع'],
                'en' => ['name' => 'Paid']
            ]
        );

        Status::create(
            [
                'ar' => ['name' => 'فشل'],
                'en' => ['name' => 'Fail']
            ]
        );
    }
}
