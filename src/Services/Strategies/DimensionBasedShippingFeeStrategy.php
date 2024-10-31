<?php

namespace App\Services\Strategies;

use App\Config\ShippingConfig;

use App\Models\Item;

class DimensionBasedShippingFeeStrategy implements ShippingFeeStrategy
{
    private ShippingConfig $shippingConfig;

    public function __construct(ShippingConfig $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    public function calculateFee(Item $item, string $feeName): float
    {
        return $item->getVolume() * $this->shippingConfig->getDimensionCoefficient();
    }
}
