<?php

namespace App\Enum;


enum StatusPublication:int
{
    case NoPublication = 0;

    case Publication = 1;

    case Document = 2;
}
