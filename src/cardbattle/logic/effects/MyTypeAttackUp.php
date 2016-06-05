<?php

namespace cardbattle\logic\effects;

class MyTypeAttackUp extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 30;
    const MESSAGE = '自属性攻撃力強化';

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($attacker['cards'], 'attack', [$params['type']]);

        return $this->makeEffect('attacker', $up);
    }
}
