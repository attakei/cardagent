<?php

require_once "vendor/autoload.php";

use cardbattle\logic\Battle;
use learning\Learner;
use cardbattle\libs\GenerateCard;

$cardgen = new GenerateCard(__DIR__ . '/data/cards.json');
$attacker = new Learner(3, 300, 5);
$defender = new Learner(3, 300, 5);
$battle = new Battle();

$attacker->setFile(__DIR__ . '/data/attack.json', false);
$defender->setFile(__DIR__ . '/data/defence.json', false);
$vic_at = 0;
$vic_de = 0;

for ($i = 0; $i < 50000; $i++) {
    $at = mt_rand(1, 3);
    $de = mt_rand(1, 3);

    $att = $cardgen->generate($at, $attacker->play($at, $de));
    //$def = $cardgen->generate($de, $defender->play($de, $at));
    $def = $cardgen->randomGenerate($de);

    $res = $battle->run($att, $def);
    if ($res > 0) {
        $vic_at += 1;
    } else {
        $vic_de += 1;
    }
}

echo "$vic_at    VS     $vic_de\n";
