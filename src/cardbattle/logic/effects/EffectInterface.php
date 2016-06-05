<?php

namespace cardbattle\logic\effects;

interface EffectInterface
{

    public function run($attacker, $defender, $params): array;
}
