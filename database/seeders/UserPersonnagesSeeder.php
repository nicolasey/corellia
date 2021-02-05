<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Factions\Models\Assignation;
use Modules\Factions\Models\Group;
use Modules\Personnages\Models\Personnage;

class UserPersonnagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faction = Group::factory()->create();
        $user = User::factory()->create(["email" => "vador@sith.gal"]);
        $personnages = Personnage::factory()->count(2)->create(['owner_id' => $user->id]);
        $personnages->each(function ($model) use ($faction) {
            Assignation::factory()->create([
                "group_id" => $faction->id,
                "element_id" => $model->id,
            ]);
        });
    }
}
