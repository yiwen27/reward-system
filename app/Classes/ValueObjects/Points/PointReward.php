<?php

declare(strict_types=1);

namespace App\Classes\ValueObjects\Points;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class PointReward {
    /** @var int */
    private int $customerId;

    /** @var int */
    private int $orderId;

    /** @var float */
    private float $totalPoints;

    /** @var string */
    private string $expiryDate;

    /**
     * PointReward constructor.
     *
     * @param int    $customerId
     * @param int    $orderId
     * @param float  $totalPoints
     * @param string $expiryDate
     */
    public function __construct(int $customerId, int $orderId, float $totalPoints, string $expiryDate) {
        $this->customerId  = $customerId;
        $this->orderId     = $orderId;
        $this->totalPoints = $totalPoints;
        $this->expiryDate  = $expiryDate;
    }

    /**
     * @param int    $customerId
     * @param int    $orderId
     * @param float  $totalPoints
     * @param string $expiryDate
     *
     * @return static
     */
    public static function createPointRewardObject(
        int $customerId,
        int $orderId,
        float $totalPoints,
        string $expiryDate
    ): self {
        return new self($customerId, $orderId, $totalPoints, $expiryDate);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int {
        return $this->customerId;
    }

    /**
     * @return int
     */
    public function getOrderId(): int {
        return $this->orderId;
    }

    /**
     * @return float
     */
    public function getTotalPoints(): float {
        return $this->totalPoints;
    }

    /**
     * @return string
     */
    public function getExpiryDate(): string {
        return $this->expiryDate;
    }
}
