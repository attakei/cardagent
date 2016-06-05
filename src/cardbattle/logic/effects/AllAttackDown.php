<?php

namespace cardbattle\logic\effects;

class AllAttackDown extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = -20;
    const MESSAGE = '全体攻撃力低下';
    const IS_ATTACK = false;

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($attacker['cards'], 'attack');

        return $this->makeEffect('attacker', $up);
    }
}
