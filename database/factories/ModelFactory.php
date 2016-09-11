<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Entities\Block::class, function(Faker\Generator $faker) {

	return [
        'size' => $faker->randomElement($array = array (25, 50, 75, 100)),
        'sequence' =>$faker->randomNumber($nbDigits = 2),
        'title' => $faker->name,
        'display_direction_id' =>$faker->randomElement($array = array (1, 2)),
        'display_dropdown_id' => $faker->randomElement($array = array (1, 2)),
        'display_graph_id' => $faker->randomElement($array=array(1,2,3,4,5,6,7)),
        'blockable_id' => function () {
            return factory(App\Entities\HeatRecentBlock::class)->create()->id;
        },
        'blockable_type' => function (array $block) {
            return App\Entities\HeatRecentBlock::find($block['id'])->type;
        }
    ];

});

$factory->define(App\Entities\HeatRecentBlock::class, 'admin', function(Faker\Generator $faker) {

	$to = $faker->date($format = 'Y-m-d', $max = 'now');
	$from = $faker->date($format = 'Y-m-d', $max = $to);

	return [
        'from' => $from,
        'to' => $to,
        'is_realtime' => true,
        'interval' => $faker->time($format = 'H:i:s', $max = 'now'),
        'role_id' => 1
    ];

});