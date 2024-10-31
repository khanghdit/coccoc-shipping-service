<?php

namespace App\Services\Strategies;

use App\Models\Item;

interface ShippingFeeStrategy
{
    public function calculateFee(Item $item, string $feeName): float;
}
