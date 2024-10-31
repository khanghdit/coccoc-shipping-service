<?php

namespace App\Services;

use App\Models\Item;

use App\Services\ShippingFeeCalculator;

class OrderCalculator
{
    private ShippingFeeCalculator $shippingFeeCalculator;

    public function __construct(ShippingFeeCalculator $shippingFeeCalculator)
    {
        $this->shippingFeeCalculator = $shippingFeeCalculator;
    }

    public function calculateGrossPrice(array $items): float
    {
        $total = 0;
        foreach ($items as $item) {
            if (!$item instanceof Item) {
                throw new \InvalidArgumentException("All elements in items array must be instances of Item.");
            }
            try {
                $itemPrice = $item->getAmazonPrice() + $this->shippingFeeCalculator->calculateShippingFee($item);
                $total += $itemPrice;
            } catch (\Exception $e) {
                throw new \RuntimeException("Error calculating shipping fee: " . $e->getMessage());
            }
        }
        return $total;
    }
}