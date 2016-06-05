<?php

namespace cardbattle\logic\effects;

class AllDefenceUp extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 20;
    const MESSAGE = '全体防御力強化';
    const IS_ATTACK = false;

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($defender['cards'], 'defence');

        return $this->makeEffect('defender', $up);
    }
}
