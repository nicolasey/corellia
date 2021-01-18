<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Forum\Models\Forum::class, function (Faker $faker) {
    static $parent_id;

    return [
        "parent_id" => ($parent_id) ? $parent_id : null,
        "name" => $faker->opera,
        "content" => $faker->sentence,
    ];
});
