<?php

namespace cardbattle\libs;

class EffectFactory
{
    private $effects = [];
    private static $instance = null;

    private $types = [
        'attacker' => 'AttackType',
        'defender' => 'DefenderType'
    ];

    private $skills = [
        1 => 'SelfAttackUp',// 自分攻撃力超強化
        2 => 'SelfDeffenceUp',// 自分防御力超強化
        3 => 'MyTypeAttackUp', // 自属性攻撃力大強化
        4 => 'MyTypeDefenceUp', // 自属性防御力大強化
        5 => 'AllAttackUp', // 全属性攻撃力小強化
        6 => 'AllDefenceUp', // 全属性防御力小強化
        7 => 'AllAttackDown', // 全属性攻撃力低下
        8 => 'AllDefenceDown', // 全属性防御力低下
        9 => 'TypeAttackDown', // 特定属性攻撃力大低下
        10 => 'TypeAttackDown', // 特定属性攻撃力大低下
        11 => 'TypeAttackDown', // 特定属性攻撃力大低下
        12 => 'TypeDefenceDown', // 特定属性防御力大低下
        13 => 'TypeDefenceDown', // 特定属性防御力大低下
        14 => 'TypeDefenceDown', // 特定属性防御力大低下
    ];

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getTypeEffect($str)
    {
        $type = $this->types[$str];
        return $this->createEffect($type);
    }


    public function getSkillEffect($id)
    {
        if (! isset($this->skills[$id])) {
            return null;
        }

        $obj = $this->createEffect($this->skills[$id]);
        $obj->setTarget($id);
        return $obj;
    }


    private function createEffect($str)
    {
        if (! isset($this->effects[$str])) {
            $class = 'cardbattle\\logic\\effects\\' . $str;
            $this->effects[$str] = new $class();
        }

        return $this->effects[$str];

    }
}
