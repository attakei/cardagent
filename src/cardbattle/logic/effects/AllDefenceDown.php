<?php

namespace cardbattle\logic\effects;

class AllDefenceDown extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = -20;
    const MESSAGE = '全体防御力低下';

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($defender['cards'], 'defence');

        return $this->makeEffect('defender', $up);
    }
}
