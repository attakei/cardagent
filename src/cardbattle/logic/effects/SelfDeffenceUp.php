<?php

namespace cardbattle\logic\effects;

class SelfDeffenceUp extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = 45;
    const MESSAGE = '自分防御力超強化';
    const IS_ATTACK = false;

    public function run($attacker, $defender, $params): array
    {
        $up = $params['defence'] * static::PARAM_COMPLEMENT;

        return $this->makeEffect('defender', $up);
    }
}
