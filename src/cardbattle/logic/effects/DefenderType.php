<?php

namespace cardbattle\logic\effects;

class DefenderType extends Base implements EffectInterface
{
    const PARAM_COMPLEMENT = 15;
    const MESSAGE = '同属性補正による防御アップ!!';

    public function run($attacker, $defender, $params): array
    {
        $type = $defender['type'];
        $up = $this->getEffectValue($defender['cards'], 'defence',[$type]);

        return $this->makeEffect('defender', $up);

    }
}
