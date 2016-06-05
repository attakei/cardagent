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
//$attacker->showModel(1, 1);
//$defender->showModel(1, 1);
//exit;
while (true) {
    $my = intval(fgets(STDIN,4096));
    $en = intval(fgets(STDIN,4096));

    echo "攻撃側\n";
    for ($i = 0; $i < 5; $i++) {
        print_r($attacker->play($my, $en));
    }

    echo "防御側\n";
    for ($i = 0; $i < 5; $i++) {
        print_r($defender->play($en, $my));
    }
    //$attacker->showModel($my, $en);
    //$defender->showModel($en, $my);
    $att = $cardgen->generate($my, $attacker->play($my, $en));
    $def = $cardgen->generate($en, $defender->play($en, $my));
    $battle->run($att, $def);
    $battle->messageExport();

}
