<?php
namespace Modules\Factions\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Factions\Models\Assignation;
use Modules\Factions\Models\Group;

class AssignationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'element_type' => 'personnages',
            'element_id' => User::factory()->create()->id,
            'group_id' => Group::factory()->create()->id,
            'isMain' => true,
            'isLeader' => false,
            'nb' => null,
        ];
    }
}