<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Translations\CountryTranslation;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
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
        if (!App::runningUnitTests())
        {
            $choice = $this->command->choice('arabic countries or random?', ['y', 'n'], 'y');
        }else{
            $choice ='y';
        }
        $this->truncate();

        if ($choice === 'y') {
            $bar = $this->command->getOutput()->createProgressBar(count($this->countries()));

            $bar->start();

            foreach ($this->countries() as $country) {
                /** @var Country $country */
                $countryModel= Country::factory()->create(Arr::except((array)$country, ['image']));
                if (is_file($country['image'])){
                    $countryModel->clearMediaCollection(Country::MEDIA_COLLECTION_NAME);
                    $countryModel->addMedia($country['image'])
                        ->preservingOriginal()
                        ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                        ->toMediaCollection(Country::MEDIA_COLLECTION_NAME);
                }

                $bar->advance();
            }

            $bar->finish();

            $this->command->info("\n");
        } else {
            Country::factory()->count($this->count)->create();
        }
    }

    private function countries(): array
    {
        return [
            [
                //insteadof 'en'=>['name'=>'saudi'],'ar'=['name'=>'السعودية']
                'name:ar' => 'السعودية',
                'name:en' => 'Saudi',
                'code' => '+966',
                'image' => public_path('flags/133-saudi-arabia.png'),
            ],
            [
                'name:ar' => 'مصر',
                'name:en' => 'Egypt',
                'code' => '+20',
                'image' => public_path('flags/158-egypt.png'),
            ],
            [
                'name:ar' => 'فلسطين',
                'name:en' => 'Palestine',
                'code' => '+970',
                'image' => public_path('flags/208-palestine.png'),
            ],
            [
                'name:ar' => 'الكويت',
                'name:en' => 'kuwait',
                'code' => '؜+965',
                'image' => public_path('flags/107-kwait.png'),
            ],
            [
                'name:ar' => 'الأردن',
                'name:en' => 'Jordan',
                'code' => '+962',
                'image' => public_path('flags/077-jordan.png'),
            ],
            [
                'name:ar' => 'العراق',
                'name:en' => 'Iraqi',
                'code' => '+964',
                'image' => public_path('flags/020-iraq.png'),
            ],
            [
                'name:ar' => 'عُمان',
                'name:en' => 'Oman',
                'code' => '+968',
                'image' => public_path('flags/004-oman.png'),
            ],
            [
                'name:ar' => 'ليبيا',
                'name:en' => 'Libya',
                'code' => '+218',
                'image' => public_path('flags/231-libya.png'),
            ],
            [
                'name:ar' => 'اليمن',
                'name:en' => 'Yemen',
                'code' => '+967',
                'image' => public_path('flags/232-yemen.png'),
            ],
            [
                'name:ar' => 'الإمارات',
                'name:en' => 'United Arab Emirates',
                'code' => '+971',
                'image' => public_path('flags/151-united-arab-emirates.png'),
            ],
            [
                'name:ar' => 'قطر',
                'name:en' => 'Qatar',
                'code' => '+974',
                'image' => public_path('flags/qatar-flag_xs.jpg'),
            ],
            [
                'name:ar' => 'سوريا',
                'name:en' => 'Syria',
                'code' => '+963',
                'image' => public_path('flags/022-syria.png'),
            ],
            [
                'name:ar' => 'لبنان',
                'name:en' => 'Lebanon',
                'code' => '+961',
                'image' => public_path('flags/018-lebanon.png'),
            ],
            [
                'name:ar' => 'السودان',
                'name:en' => 'Sudan',
                'code' => '+249',
                'image' => public_path('flags/199-sudan.png'),
            ],
            [
                'name:ar' => 'البحرين',
                'name:en' => 'Bahrain',
                'code' => '+973',
                'image' => public_path('flags/138-bahrain.png'),
            ],
            [
                'name:ar' => 'الجزائر',
                'name:en' => 'Algeria',
                'code' => '+213',
                'image' => public_path('flags/144-algeria.png'),
            ],
            [
                'name:ar' => 'المغرب',
                'name:en' => 'Morocco',
                'code' => '+212',
                'image' => public_path('flags/166-morocco.png'),
            ],
            [
                'name:ar' => 'تونس',
                'name:en' => 'Tunisia',
                'code' => '+216',
                'image' => public_path('flags/049-tunisia.png'),
            ],
            [
                'name:ar' => 'الصومال',
                'name:en' => 'Somalia',
                'code' => '+252',
                'image' => public_path('flags/083-somalia.png'),
            ],
            [
                'name:ar' => 'جيبوتى',
                'name:en' => 'Jabuuti',
                'code' => '+253',
                'image' => public_path('flags/Jabuuti.png'),
            ],
            [
                'name:ar' => 'جزر القمر',
                'name:en' => 'Union des Comores',
                'code' => '+269',
                'image' => public_path('flags/Union.png'),
            ],
            [
                'name:ar' => 'موريتانيا',
                'name:en' => 'Mauritania',
                'code' => '+222',
                'image' => public_path('flags/Mauritania.png'),
            ],
        ];
    }

    private function truncate()
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        CountryTranslation::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
