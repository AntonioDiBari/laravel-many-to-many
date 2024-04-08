<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $type_names = ['scolastico', 'lavorativo', 'sportivo'];
        foreach ($type_names as $type_name) {

            $type = new Type;

            $type->name = $type_name;
            $type->abstract = $faker->words(5, true);
            $type->color = $faker->hexColor();
            $type->save();
        }
    }
}
