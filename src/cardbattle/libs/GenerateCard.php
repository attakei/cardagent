<?php

namespace cardbattle\libs;

class GenerateCard
{
    private $cards;

    public function __construct($file)
    {
        $json = file_get_contents($file);
        $this->cards = json_decode($json, true);
    }


    public function generate($type, $arr)
    {
        $ret = [];
        $ret['type'] = $type;
        $counter = 1;
        $ret['cards'] = [];
        foreach ($arr as $val) {
            $ret['cards'][$counter] = $this->cards[$val];
            $counter++;
            if ($counter > 6) {
                break;
            }
        }

        return $ret;

    }
}
