<?php

namespace App\Traits;

use Carbon\CarbonInterval;

trait HasFormattedDuration
{
    public function getFormattedDuration()
    {
        $interval = CarbonInterval::seconds($this->duration)->cascade();

        $formatted = [];

        if ($interval->hours > 0) {
            $formatted[] = $interval->hours.'h';
        }

        if ($interval->minutes > 0) {
            $formatted[] = $interval->minutes.'m';
        }

        $formatted[] = $interval->seconds.'s';

        return implode(' ', $formatted);
    }
}
