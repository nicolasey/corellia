<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Forum\Models\Post::class, function (Faker $faker) {
    static $author;
    static $topic_id;

    return [
        "author" => ($author) ? $author : factory(\Nicolasey\Personnages\Models\Personnage::class)->create()->id,
        "topic_id" => ($topic_id) ? $topic_id : factory(\Modules\Forum\Models\Topic::class)->create()->id,
        "content" => $faker->paragraph
    ];
});
