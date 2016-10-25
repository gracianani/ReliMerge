<?php

namespace App\Observers;

use App\Entities\Heatource;
use ReliHeatsources;
use Reli;

class HeatsourceObserver
{
    public function updating( $heatsource)
    {
        // $heatsource->{'东西部'} = $heatsource->district;
        // $heatsource->name = $heatsource->name.'1';
    }
}