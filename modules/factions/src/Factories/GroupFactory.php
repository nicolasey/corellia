<?php
namespace Modules\Factions\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Factions\Models\Group;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'color' => $this->faker->unique()->hexColor,
            'isFaction' => true,
            'content' => $this->faker->paragraph
        ];
    }
}