<?php

namespace cardbattle\logic\effects;

class MyTypeDefenceUp extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 30;
    const MESSAGE = '自属性防御力強化';
    const IS_ATTACK = false;

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($defender['cards'], 'defence', [$params['type']]);

        return $this->makeEffect('defender', $up);
    }
}
