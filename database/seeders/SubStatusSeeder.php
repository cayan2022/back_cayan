<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\SubStatus;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class SubStatusSeeder extends Seeder
{
    /**
     * @var Repository|Application|mixed
     */
    private $count;

    public function __construct()
    {
        $this->count=config('database.seeder_count');
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubStatus::factory()->count($this->count)->for(Status::inRandomOrder()->first())->create();
    }
}
