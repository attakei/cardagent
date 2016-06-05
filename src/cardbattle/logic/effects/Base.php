<?php
namespace cardbattle\logic\effects;

class Base
{

    const PARAM_COMPLEMENT = 0;
    const MESSAGE = '';
    const IS_ATTACK = true;

    protected $target = 1;

    protected function getEffectValue($cards, $status, $typeFilter = [])
    {
        $up = 0;
        foreach ($cards as $val) {
            if ($typeFilter == [] or in_array($val['type'], $typeFilter)) {
                $up += $val[$status] * static::PARAM_COMPLEMENT;
            }
        }

        return floor($up);
    }

    protected function makeEffect($side, $up)
    {
        return [
            'side' => $side,
            'effect' => floor($up / 100),
            'message' => $this->makeMessage()
        ];
    }

    protected function makeMessage()
    {
        return static::MESSAGE;
    }


    public function is_attack()
    {
        return static::IS_ATTACK;
    }


    public function is_defence()
    {
        return ! static::IS_ATTACK;
    }


    public function setTarget($id)
    {
        $this->target = ($id % 3) + 1;
    }
}
