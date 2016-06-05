<?php

namespace cardbattle\logic\effects;

class AllAttackUp extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 20;
    const MESSAGE = '全体攻撃力強化';

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($attacker['cards'], 'attack');

        return $this->makeEffect('attacker', $up);
    }
}
