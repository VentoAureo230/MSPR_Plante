<?php

namespace App\Service;


class LevelCalculator
{

    public function getLevel($experience){
            $level = $experience/10;
            if ($level < 1){
                return 1;
            }
            return $level;
        }
}