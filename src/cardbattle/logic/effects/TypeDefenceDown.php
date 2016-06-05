<?php

namespace cardbattle\logic\effects;

class TypeDefenceDown extends Base implements EffectInterface
{

    const PARAM_COMPLEMENT = -33;
    const MESSAGE = '敵属性防御力低下';

    public function run($attacker, $defender, $params): array
    {
        $up = $this->getEffectValue($defender['cards'], 'defence', [$this->target]);

        return $this->makeEffect('defender', $up);
    }
}
