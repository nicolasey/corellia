<?php

namespace Modules\Personnages\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Personnages\Models\Personnage;

class PersonnageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Personnage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'job' => $this->faker->jobTitle(),
            'title' => $this->faker->jobTitle(),
            'bio' => $this->faker->paragraph,
            'affections' => $this->faker->paragraph,
            'aversions' => $this->faker->paragraph,
            'signature' => $this->faker->paragraph,
            'owner_id' => User::factory()->create()->id,
        ];
    }
}