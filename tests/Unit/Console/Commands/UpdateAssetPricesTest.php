<?php

namespace Tests\Unit\Console\Commands;

use App\Architect\AssetPriceProvider\AssetPriceProvider;
use App\Console\Commands\UpdateAssetPrices;
use App\Models\AssetPrice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\Architect\AssetPriceProvider\TestProvider;

class UpdateAssetPricesTest extends TestCase
{
    public function test_ShouldDownloadAndStoreOnDatabase() {

        $command = new UpdateAssetPricesForTests();
        $command->handle();

        $assetPricesSaved = AssetPrice::all();
        $firstAssetPrice = $assetPricesSaved->first();
        $fakeData = (new TestProvider())->fetchHistoricalData('AAPL');

        $this->assertCount(2, $assetPricesSaved);
        $this->assertEquals($fakeData[0]->openPrice, $firstAssetPrice->open);
        $this->assertEquals($fakeData[0]->tradeVolume, $firstAssetPrice->trade_volume);
        $this->assertEquals($fakeData[0]->highPrice, $firstAssetPrice->high);
        $this->assertEquals($fakeData[0]->lowPrice, $firstAssetPrice->low);
        $this->assertEquals($fakeData[0]->closePrice, $firstAssetPrice->close);
        $this->assertEquals($fakeData[0]->timestamp, $firstAssetPrice->timestamp);
    }

    public function test_ShouldNotInsertDuplicatePrices() {
        $command = new UpdateAssetPricesForTests();
        $command->handle();
        $command->handle();

        $assetPricesSaved = AssetPrice::all();

        $this->assertCount(2, $assetPricesSaved);
    }
}

class UpdateAssetPricesForTests extends UpdateAssetPrices
{
    protected function getProvider(): AssetPriceProvider
    {
        return new TestProvider();
    }
}
