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

    private $training_count = 90000;
    private $max_epsiron = 1000000;
    private $min_epsiron = 200000;
    private $diff_epsiron = 10;
    private $random = false;

    public function __construct($types, $cards_count, $deck)
    {
        for ($i = 1; $i < $types + 1; $i++) {
            for ($j = 1; $j < $types; $j++) {
                $this->model[$i][$j] = $this->initialDeck($cards_count, $deck);
            }
        }
        $this->model['net'] = array_fill(1, $cards_count, array_fill(1, $cards_count, [0.0, 0]));
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

        if (mt_rand(1, $this->max_epsiron) < $this->epsiron) {
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
        $res = ($result > 0)? 1 : 0;
        $first = $this->temp['cards'][1];
        $this->updateOdds($this->model[$myType][$enType]['first'][$first], $res);

        $prev = 0;
        foreach ($this->temp['cards'] as $val) {
            if ($prev == 0) {
                $prev = $val;
                continue;
            }

            //print_r($this->model[$myType][$enType]['net'][$prev][$val]);
            //exit;

            $this->updateOdds($this->model['net'][$prev][$val], $res);
            $prev = $val;
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
                if ($rec[0] > 0.2) {
                    echo "   $id => $rec[0]\n";
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
        $prev = $this->recommendCore($model['first']);
        $ret = [];
        $ret[] = $prev;
        $this->temp['cards'][1] = $prev;
        for ($i = 2; $i < $this->deck + 1; $i++) {
            $id = $this->recommendCore($this->model['net'][$prev]);
            $ret[] = $id;
            $this->temp['cards'][$i] = $id;
            $prev = $id;
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
            $val = $model[$key][0];
            if ($id == null) {
                $id = $key;
                $score = $val;
                continue;
            }

            if ($val == 0) {
                continue;
            }

            if ($val - $score > 0.1) {
                $id = $key;
                $score = $val;
            } else if ($val - $score > 0.05) {
                if (mt_rand(1, 10) > 3) {
                    $id = $key;
                    $score = $val;
                }
            } else if ($val - $score > -0.05) {
                if (mt_rand(1, 10) > 8) {
                    $id = $key;
                    $score = $val;
                }
            }
        }

        return $id;

    }


    private function initialDeck($cards_count, $deck)
    {
        $ret = [];
        $ret['first'] = array_fill(1, $cards_count, [0.0, 0]);

        return $ret;
    }


    private function updateOdds(&$obj, $judge)
    {
        $obj[1]++;
        $obj[0] = ($obj[0] * ($obj[1] - 1) + $judge) / $obj[1];
    }

}
