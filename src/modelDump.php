<?php

echo "===============カードデータ===========\n";
$data = json_decode(file_get_contents('../data/cards.json'), true);
foreach ($data as $val) {
    echo "\n{$val['id']}\n{$val['type']}\n{$val['attack']}\n{$val['defence']}\n{$val['skill']}\n";
}

echo "\n===============攻撃側===========\n";
$attack = json_decode(file_get_contents('../data/attack.json'), true);
foreach ($attack as $val) {
    foreach ($val as $my => $rec) {
        echo "my type is $my\n";
        foreach ($rec as $en => $cards) {
            echo "  enemy type is $en\n";
            foreach ($cards as $key => $card) {
                echo "    $key: {$card[0]}\n";
            }
        }
    }
}

echo "\n===============防御側===========\n";
$attack = json_decode(file_get_contents('../data/defence.json'), true);
foreach ($attack as $val) {
    foreach ($val as $my => $rec) {
        echo "my type is $my\n";
        foreach ($rec as $en => $cards) {
            echo "  enemy type is $en\n";
            foreach ($cards as $key => $card) {
                echo "    $key: {$card[0]}\n";
            }
        }
    }
}
