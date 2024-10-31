<?php

namespace App\Services;

use App\Services\Strategies\ShippingFeeStrategy;

use App\Models\Item;

class ShippingFeeCalculator
{
    private array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function addStrategy(ShippingFeeStrategy $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function calculateShippingFee(Item $item): float
    {
        if (!$item instanceof Item) {
            throw new \InvalidArgumentException("The provided item must be an instance of Item.");
        }

        try {
            $otherFees = $item->getAllOtherFees();
            $fees = array_map(fn($strategy) => $strategy->calculateFee($item, ""), $this->strategies);

            if (empty($otherFees)) {
                return max($fees);
            }
            
            $arrayFees = [max($fees)];

            foreach ($item->getAllOtherFees() as $feeName => $feeValue) {
                $fees = array_map(fn($strategy) => $strategy->calculateFee($item, $feeName), $this->strategies);
                $arrayFees[] = max($fees);
            }
            return max($arrayFees);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error calculating shipping fee: " . $e->getMessage());
        }
    }
}