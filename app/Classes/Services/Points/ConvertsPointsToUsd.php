<?php

declare(strict_types=1);

namespace App\Classes\Services\Points;

use App\Classes\Constants;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class ConvertsPointsToUsd {
    /**
     * @param float $points
     *
     * @return float
     */
    public function execute(float $points): float {
        return $points * Constants::POINT_TO_USD_CONVERSION_RATE;
    }
}
