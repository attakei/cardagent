<?php

namespace cardbattle\logic\effects;

class AttackType extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 15;
    const MESSAGE = '同属性補正による攻撃力アップ!!';

    public function run($attacker, $defender, $params): array
    {
        $type = $attacker['type'];
        $up = $this->getEffectValue($attacker['cards'], 'attack',[$type]);

        return $this->makeEffect('attacker', $up);

    }
}
