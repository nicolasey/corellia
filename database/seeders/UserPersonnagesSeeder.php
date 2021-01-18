<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $user = User::factory()->create(["email" => "vador@sith.gal"]);
        Personnage::factory()->count(2)->create(['owner_id' => $user->id]);
    }
}
