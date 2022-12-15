<?php

namespace App\Service;


class LevelCalculator
{

    public function getLevel($experience){
            $level = $experience/3;
            if ($level < 1){
                return 1;
            }
            $float_int = (int)$level;
            return $float_int;
        }
}