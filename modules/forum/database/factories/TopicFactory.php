<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Forum\Models\Topic::class, function (Faker $faker) {
    static $author;
    static $forum_id;

    return [
        "author" => ($author) ? $author : factory(\Nicolasey\Personnages\Models\Personnage::class)->create()->id,
        "forum_id" => ($forum_id) ? $forum_id : factory(\Modules\Forum\Models\Forum::class)->create()->id,
        "name" => $faker->sentence,
        "content" => null
    ];
});
