<?php
namespace learning;

class Learner
{
    private $file_path;
    private $model = [];
    private $deck;
    private $card_count;

    private $epsiron;
    private $count = 0;
    private $temp;

    private $training_count = 30000;
    private $max_epsiron = 1000000;
    private $min_epsiron = 200000;
    private $diff_epsiron = 100;
    private $random = false;

    public function __construct($types, $cards_count, $deck)
    {
        for ($i = 1; $i < $types; $i++) {
            for ($j = 1; $j < $types; $j++) {
                $this->model[$i][$j] = $this->initialDeck($cards_count, $deck);
            }
        }
        $this->epsiron = $this->max_epsiron;
        $this->deck = $deck;
        $this->card_count = $cards_count;

    }

    public function setFile($path, $initialize = true)
    {
        $this->file_path = $path;
        if ($initialize or ! file_exists($path)) {
            return;
        }

        $json = file_get_contents($path);
        $this->model = json_decode($json, true);
    }

    public function train($myType, $enType)
    {
        $this->random = true;
        $this->temp = [
            'myType' => $myType,
            'enType' => $enType
        ];

        if ($this->count > $this->training_count and $this->epsiron > $this->min_epsiron) {
            $this->epsiron -= $this->diff_epsiron;
        }

        $this->count++;

        if ($this->count < $this->training_count or mt_rand(1, $this->max_epsiron) < $this->epsiron) {
            return $this->random($myType, $enType);
        }

        $this->random = false;

        return $this->recommend($myType, $enType);
    }

    public function play($my, $en)
    {
        return $this->recommend($my, $en);
    }


    public function feedback($result)
    {
        $myType = $this->temp['myType'];
        $enType = $this->temp['enType'];
        $res = ($result > 0)? 1 : -5;

        foreach ($this->temp['cards'] as $key => $val) {
            $tmp = $this->model[$myType][$enType][$key][$val];
            $tmp += $res * ($this->deck - $key + 1);//ceil($result / 1000);
            $this->model[$myType][$enType][$key][$val] = max($tmp, 0);
        }
    }


    public function export()
    {
        file_put_contents($this->file_path, json_encode($this->model));
    }


    public function showModel($my, $en)
    {
        foreach($this->model[$my][$en] as $key => $val) {
            echo "$key => \n";
            foreach ($val as $id => $rec) {
                if ($rec > 0) {
                    echo "   $id => $rec\n";
                }
            }
        }
    }


    private function random($myType, $enType)
    {
        $ret = [];
        for ($i = 1; $i < $this->deck + 1; $i++) {
            $id = mt_rand(1, $this->card_count);
            $ret[] = $id;
            $this->temp['cards'][$i] = $id;
        }

        return $ret;
    }


    private function recommend($myType, $enType)
    {
        $model = $this->model[$myType][$enType];
        for ($i = 1; $i < $this->deck + 1; $i++) {
            $id = $this->recommendCore($model[$i]);
            $ret[] = $id;
            $this->temp['cards'][$i] = $id;
        }

        return $ret;
    }

    private function recommendCore($model)
    {
        $id = null;
        $score = null;
        $keys = array_keys($model);
        shuffle($keys);
        foreach ($keys as $key) {
            $val = $model[$key];
            if ($id == null) {
                $id = $key;
                $score = $val;
                continue;
            }

            if ($val == 0) {
                continue;
            }

            if (mt_rand(0, $score * $score + $val * $val) < $score * $score) {
                $id = $key;
                $score = $val;
            }
        }

        return $id;

    }


    private function initialDeck($cards_count, $deck)
    {
        $ret = [];
        for ($i = 1; $i < $deck + 1; $i++) {
            $ret[$i] = array_fill(1, $cards_count, 0);
        }

        return $ret;
    }

}
