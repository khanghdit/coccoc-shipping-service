<?php

namespace App\Services\Strategies;

use App\Models\Item;

class OtherBasedShippingFeeStrategy implements ShippingFeeStrategy
{
    private array $otherFees;

    public function __construct(array $otherFees = [])
    {
        $this->otherFees = $otherFees;
    }

    public function calculateFee(Item $item, string $feeKey): float
    {
        $other = $item->otherFeesByKey($feeKey);
        return $this->otherFees[$other] ?? 0;
    }
}
