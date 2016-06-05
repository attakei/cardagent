<?php

namespace cardbattle\logic\effects;

class SelfAttackUp extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 45;
    const MESSAGE = '自分超強化';
    const IS_ATTACK = true;

    public function run($attacker, $defender, $params): array
    {
        $up = $params['attack'] * static::PARAM_COMPLEMENT;

        return $this->makeEffect('attacker', $up);
    }
}
