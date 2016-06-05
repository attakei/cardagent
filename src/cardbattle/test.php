<?php
namespace cardbattle;
require_once "../../vendor/autoload.php";

$battle = new logic\Battle();

$attacker = [
    'type' => 1,
    'cards' => [
        1 => [
            'id' => 3,
            'type' => 1,
            'attack' => 15000,
            'defence' => 10000,
            'skill'   => 1
        ],
        2 => [
            'id' => 32,
            'type' => 1,
            'attack' => 15000,
            'defence' => 10000,
            'skill'   => 0
        ],
        3 => [
            'id' => 7,
            'type' => 1,
            'attack' => 15000,
            'defence' => 10000,
            'skill'   => 5
        ],
        4 => [
            'id' => 5,
            'type' => 2,
            'attack' => 12000,
            'defence' => 10000,
            'skill'   => 3
        ],
        5 => [
            'id' => 66,
            'type' => 3,
            'attack' => 15400,
            'defence' => 10000,
            'skill'   => 10
        ],
    ]
];

$defender = [
    'type' => 2,
    'cards' => [
        1 => [
            'id' => 24,
            'type' => 2,
            'attack' => 12000,
            'defence' => 15000,
            'skill'   => 2
        ],
        2 => [
            'id' => 33,
            'type' => 2,
            'attack' => 15000,
            'defence' => 16000,
            'skill'   => 4
        ],
        3 => [
            'id' => 334,
            'type' => 2,
            'attack' => 15000,
            'defence' => 17000,
            'skill'   => 0
        ],
        4 => [
            'id' => 5,
            'type' => 3,
            'attack' => 12000,
            'defence' => 14000,
            'skill'   => 12
        ],
        5 => [
            'id' => 66,
            'type' => 3,
            'attack' => 15400,
            'defence' => 10000,
            'skill'   => 10
        ],
    ]
];

$battle->run($attacker, $defender);
