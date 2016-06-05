<?php

namespace cardbattle\logic\effects;

class TypeAttackDown extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = -33;
    const MESSAGE = '敵特定属性攻撃力低下';
    const IS_ATTACK = false;

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($attacker['cards'], 'attack', [$this->target]);

        return $this->makeEffect('attacker', $up);
    }
}
