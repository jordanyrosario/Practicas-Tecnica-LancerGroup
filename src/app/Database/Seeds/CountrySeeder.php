<?php

namespace App\Database\Seeds;

use App\Models\CountryModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Void_;

class CountrySeeder extends Seeder
{
    public function run():void
    {
        $countryModel = new CountryModel();
        $faker        = Factory::create();

        for ($index = 0; $index < 50; $index++) {
            $countryModel->save(
                [
                    'name' => $faker->country(),
                ]
            );
        }
    }
}
