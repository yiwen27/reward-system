<?php

declare(strict_types=1);

namespace App\Classes\ValueObjects\Points;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class PointRedemption {
    /** @var float */
    private float $redeemedPoints;

    /** @var float */
    private float $outstandingAmount;

    /**
     * PointRedemption constructor.
     *
     * @param float $redeemedPoints
     * @param float $outstandingAmount
     */
    public function __construct(float $redeemedPoints, float $outstandingAmount) {
        $this->redeemedPoints    = $redeemedPoints;
        $this->outstandingAmount = $outstandingAmount;
    }

    /**
     * @param float $redeemedPoints
     * @param float $outstandingAmount
     *
     * @return static
     */
    public static function createAfterRedemption(float $redeemedPoints, float $outstandingAmount): self {
        return new self($redeemedPoints, $outstandingAmount);
    }

    /**
     * @return float
     */
    public function getRedeemedPoints(): float {
        return $this->redeemedPoints;
    }

    /**
     * @return float
     */
    public function getOutstandingAmount(): float {
        return round($this->outstandingAmount, 2);
    }
}
