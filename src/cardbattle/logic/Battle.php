<?php

namespace cardbattle\logic;

use cardbattle\libs\EffectFactory;

class Battle
{

    const INITIAL_RATE = 100;
    const COUNT_RATE   = 25;

    private $attacker;
    private $defender;
    private $effects;
    private $factory;

    public function run($attacker, $defender)
    {
        $this->init($attacker, $defender);
        $this->typeEffect();
        $this->attackSkillEffect();
        $this->defenceSkillEffect();
        $res = $this->exec();

        if ($res > 0) {
            //echo '攻撃側の勝ち'.PHP_EOL;
        } else {
            //echo '防御側の勝ち'.PHP_EOL;
        }

        return $res;
    }

    public function messageExport()
    {
        foreach ($this->effects as $val) {
            echo "{$val['side']}: {$val['message']} -> {$val['effect']}\n";
        }
    }


    private function init($attacker, $defender)
    {
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->effects = [];
        $this->factory = EffectFactory::getInstance();

    }

    private function typeEffect()
    {
        foreach (['attacker', 'defender'] as $str) {
            $obj = $this->factory->getTypeEffect($str);
            $this->effects[] = $obj->run($this->attacker, $this->defender, []);
        }

    }


    private function attackSkillEffect()
    {
        $this->skillEffect('attacker', 'is_attack');
    }

    private function defenceSkillEffect()
    {
        $this->skillEffect('defender', 'is_defence');
    }

    private function skillEffect($side, $method)
    {
        $rate = self::INITIAL_RATE;
        $stock = [];
        foreach ($this->{$side}['cards'] as $val) {
            $obj = $this->factory->getSkillEffect($val['skill']);

            if ($obj == null) {
                continue;
            }

            if ($obj->{$method}() === false) {
                continue;
            }

            $correction = (in_array($val['id'], $stock)) ? 2 : 1;

            if (mt_rand(0, self::INITIAL_RATE) > $rate / $correction) {
                continue;
            }

            $this->effects[] = $obj->run($this->attacker, $this->defender, $val);
            $rate -= self::COUNT_RATE;
            $stock[] = $val['id'];
        }
    }


    private function exec()
    {
        $attack = 0;
        foreach ($this->attacker['cards'] as $val) {
            $attack += $val['attack'];
        }

        $defence = 0;
        foreach ($this->defender['cards'] as $val) {
            $defence += $val['defence'];
        }

        //echo "attack: $attack\n";
        //echo "defence: $defence\n";
        foreach ($this->effects as $val) {
            $status = ($val['side'] == 'attacker') ? 'attack' : 'defence';
            $$status += $val['effect'];
            //echo "$status: {$$status}\n";
            //echo $val['message'].' + '. $val[effect] .PHP_EOL;
        }

        //echo "attack: $attack   VS    defence: $defence\n";
        $this->effects[] = [
            'side' => 'result',
            'message' => "$attack    VS    $defence",
            'up' => 0
        ];

        return $attack - $defence;
    }
}
