<?php

namespace App\Models;

class Item
{
    private float $amazonPrice;
    private float $weight;
    private float $width;
    private float $height;
    private float $depth;
    private array $otherFees;

    public function __construct(float $amazonPrice, float $weight, float $width, float $height, float $depth, array $otherFees = [])
    {
        $this->validateInput($amazonPrice, "Amazon price must be non-negative.");
        $this->validateInput($weight, "Weight must be greater than zero.");
        $this->validateInput($width, "Width must be greater than zero.");
        $this->validateInput($height, "Width must be greater than zero.");
        $this->validateInput($depth, "Width must be greater than zero.");

        $this->amazonPrice = $amazonPrice;
        $this->weight = $weight;
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
        $this->otherFees = $otherFees;
    }

    private function validateInput($value, string $message): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException($message);
        }
    }

    public function getAmazonPrice(): float
    {
        return $this->amazonPrice;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getVolume(): float
    {
        return $this->width * $this->height * $this->depth;
    }

    public function otherFeesByKey(string $feeKey): ?string
    {
        return $this->otherFees[$feeKey] ?? null;
    }

    public function getAllOtherFees(): array
    {
        return $this->otherFees;
    }
}
