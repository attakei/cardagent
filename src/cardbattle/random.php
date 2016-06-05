<?php
namespace cardbattle;
require_once "../../vendor/autoload.php";

$battle = new logic\Battle();
$generater = new libs\GenerateCard(__DIR__ . '/../../data/cards.json');

for ($i = 1; $i < 5; $i++) {
    foreach(['attack', 'defend'] as $val) {
        $$val = $generater->generate(mt_rand(1, 3), createCardId());
    }
    $battle->run($attack, $defend);
}

function createCardId()
{
    $ret = [];
    for ($i = 0; $i < 5; $i++) {
        $ret[] = mt_rand(1, 400);
    }

    return $ret;
}
