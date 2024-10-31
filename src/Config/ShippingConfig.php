<?php

namespace App\Config;

class ShippingConfig
{
    private float $weightCoefficient;
    private float $dimensionCoefficient;

    public function __construct(float $weightCoefficient, float $dimensionCoefficient)
    {
        if ($weightCoefficient <= 0) {
            throw new \InvalidArgumentException("Weight coefficient must be greater than zero.");
        }

        if ($dimensionCoefficient <= 0) {
            throw new \InvalidArgumentException("Dimension coefficient must be greater than zero.");
        }

        $this->weightCoefficient = $weightCoefficient;
        $this->dimensionCoefficient = $dimensionCoefficient;
    }

    public function getWeightCoefficient(): float
    {
        return $this->weightCoefficient;
    }

    public function getDimensionCoefficient(): float
    {
        return $this->dimensionCoefficient;
    }
}
