<?php
namespace Tests;

use App\Config\ShippingConfig;

use App\Models\Item;

use App\Services\ShippingFeeCalculator;
use App\Services\Strategies\DimensionBasedShippingFeeStrategy;
use App\Services\Strategies\WeightBasedShippingFeeStrategy;

use PHPUnit\Framework\TestCase;

class ShippingFeeCalculatorTest extends TestCase
{
    public function testCalculateShippingFee(): void
    {
        $config = new ShippingConfig(10, 5);
        $strategies = [
            new DimensionBasedShippingFeeStrategy($config),
            new WeightBasedShippingFeeStrategy($config),
        ];
        $calculator = new ShippingFeeCalculator($strategies);
        $item = new Item(100, 2, 0.3, 0.4, 0.5);

        $fee = $calculator->calculateShippingFee($item);
        $this->assertEquals(20, $fee);
    }

    public function testAddStrategy(): void
    {
        $config = new ShippingConfig(10, 5);
        $calculator = new ShippingFeeCalculator([]);
        $strategy = new WeightBasedShippingFeeStrategy($config);

        $calculator->addStrategy($strategy);
        $item = new Item(100, 2, 0.3, 0.4, 0.5);

        $fee = $calculator->calculateShippingFee($item);
        $this->assertEquals(20, $fee);
    }
}