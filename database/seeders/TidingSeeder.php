<?php

namespace Database\Seeders;

use App\Models\Tiding;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class TidingSeeder extends Seeder
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
        $news = Tiding::factory()->count($this->count)->create();
//        $faker = Faker::create();
//        $imageUrl = $faker->imageUrl(640,480, null, false);
//
//        foreach($news as $new){
//            $new->addMedia(public_path(Tiding::MEDIA_COLLECTION_URL))->toMediaCollection('news_avatar');
//        }
           //   ->each(fn($new) => $new->addMedia(public_path('\images\news.jpg'))->toMediaCollection('news_avatar'));
    }
}
