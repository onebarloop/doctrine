<?php

namespace App\Service;

class Randicon
{
    public function getRandicon()
    {
        $emoticons = [128512, 128513, 128515, 128516, 128519, 128524, 128527];

        $index = array_rand($emoticons);

        return mb_chr($emoticons[$index], 'UTF-8');
    }
}
