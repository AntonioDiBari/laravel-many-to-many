<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projects = Project::all();
        $technologies = Technology::all()->pluck('id');


        foreach ($projects as $project) {

            /* per ogni progetto relazionato alle tecnologie uso la funzione che relaziona nel model
            per associare da una a tre tecnologie randomicamente, grazie al
            sync nella tabella pivot che svuota (detach) e inserisce (attach) i records (FK) */

            $project->technologies()->sync($faker->randomElements($technologies, rand(1, 3)));
        }


    }
}
