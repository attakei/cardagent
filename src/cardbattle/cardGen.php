<?php

$cards = [];

for($i = 1; $i < 301; $i++) {
    $skill = mt_rand(0, 14);
    if ($skill == 0) {
        $attack = mt_rand(18500, 20500);
        $defence = mt_rand(18500, 20500);
    } else if (in_array($skill, [1, 3, 5, 8, 12, 13, 14])) {
        $attack = mt_rand(18000, 21000);
        $defence = mt_rand(12000, 18000);
    } else {
        $attack = mt_rand(12000, 18000);
        $defence = mt_rand(18000, 21000);
    }
    $temp = [
        'id' => $i,
        'type' => mt_rand(1, 3),
        'attack' => $attack,
        'defence' => $defence,
        'skill' => $skill
    ];

    $cards[$i] = $temp;
}

$str = json_encode($cards);
file_put_contents('../../data/cards.json', $str);
