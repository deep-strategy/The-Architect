<?php

namespace Tests\Unit\Console\Commands;

use App\Architect\AssetPriceProvider\AlphaVantageProvider;
use App\Architect\AssetPriceProvider\AssetPriceDetail;
use App\Models\PriceFrequency;
use Tests\TestCase;

class AlphaVantageProviderTest extends TestCase
{
    public function test_ShouldReturnValidJSONData()
    {
        $provider = new AlphaVantageProvider();
        $downloadedData = $provider->fetchHistoricalData('AAPL', '1min');

        $this->assertGreaterThan(0, count($downloadedData));
        $this->assertInstanceOf(AssetPriceDetail::class, $downloadedData[0]);
    }
}

