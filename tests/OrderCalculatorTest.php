<?php

namespace Tests;

use App\Config\ShippingConfig;

use App\Models\Item;

use App\Services\OrderCalculator;
use App\Services\ShippingFeeCalculator;
use App\Services\Strategies\DimensionBasedShippingFeeStrategy;
use App\Services\Strategies\WeightBasedShippingFeeStrategy;
use App\Services\Strategies\OtherBasedShippingFeeStrategy;

use PHPUnit\Framework\TestCase;

class OrderCalculatorTest extends TestCase
{
    protected function setUpCalculator(float $weightCoefficient, float $dimensionCoefficient): array
    {
        $config = new ShippingConfig($weightCoefficient, $dimensionCoefficient);

        $shippingFeeCalculator = new ShippingFeeCalculator([
            new DimensionBasedShippingFeeStrategy($config),
            new WeightBasedShippingFeeStrategy($config),
        ]);

        $orderCalculator = new OrderCalculator($shippingFeeCalculator);

        return [
            "orderCalculator" => $orderCalculator,
            "shippingFeeCalculator" => $shippingFeeCalculator,
        ];
    }

    public function testCalculateGrossPrice(): void
    {
        $calculators = $this->setUpCalculator(11, 11);
        $orderCalculator = $calculators["orderCalculator"];

        $items = [
            new Item(199, 0.2, 0.3, 0.4, 0.5),
            new Item(250, 3, 0.4, 0.6, 0.8),
        ];

        $fee = $orderCalculator->calculateGrossPrice($items);

        $this->assertEquals(484.2, $fee);
    }

    public function testCalculateGrossPriceWithInvalidItem(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $calculators = $this->setUpCalculator(11, 11);
        $orderCalculator = $calculators["orderCalculator"];

        $invalidItem = new \stdClass();

        $orderCalculator->calculateGrossPrice([$invalidItem]);
    }

    public function testCalculateGrossPriceWithEmptyItem(): void
    {
        $calculators = $this->setUpCalculator(11, 11);
        $orderCalculator = $calculators["orderCalculator"];

        $fee = $orderCalculator->calculateGrossPrice([]);

        $this->assertEquals(0, $fee);
    }

    public function testCalculateGrossPriceWithProductTypeFee(): void
    {
        $calculators = $this->setUpCalculator(11, 11);
        $orderCalculator = $calculators["orderCalculator"];
        $shippingFeeCalculator = $calculators["shippingFeeCalculator"];

        $productTypeFees = [
            "smartphone" => 20,
            "diamondRing" => 60,
        ];

        $productTypeFeeStategy = new OtherBasedShippingFeeStrategy($productTypeFees);
        $shippingFeeCalculator->addStrategy($productTypeFeeStategy);

        $items = [
            new Item(199, 0.2, 0.3, 0.4, 0.5, ["diamondRing"]),
            new Item(250, 3, 0.4, 0.6, 0.8, ["smartphone"]),
        ];

        $fee = $orderCalculator->calculateGrossPrice($items);

        $this->assertEquals(542, $fee);
    }
}
