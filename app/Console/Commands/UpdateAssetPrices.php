<?php

namespace App\Console\Commands;

use App\Architect\AssetPriceProvider\AlphaVantageProvider;
use App\Architect\AssetPriceProvider\AssetPriceProvider;
use App\Models\PriceFrequency;
use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\AssetPrice;
use App\Architect\HTTPRequest\HTTPRequest;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;
class UpdateAssetPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:update-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads and updates prices of all assets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getProvider(): AssetPriceProvider
    {
        return new AlphaVantageProvider();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = new Carbon();
        $assets = Asset::all();
        $frequencies = PriceFrequency::all();
        foreach ($assets as $asset) {
            $this->updateAssetPrices($frequencies, $asset, $now);
        }
        return;
    }


    protected function updateAssetPrices(Collection $frequencies, Asset $asset, Carbon $now): void
    {
        /** @var PriceFrequency $frequency */
        foreach ($frequencies as $frequency) {
            $downloadedHistory = $this->getProvider()->fetchHistoricalData($asset->symbol, $frequency->slug);
            $assetPriceBuffer = [];
            foreach ($downloadedHistory as $assetDetailsOnDate) {
                $assetPriceBuffer[] = [
                    'asset_id' => $asset->id,
                    'price_frequency_id' => $frequency->id,
                    'timestamp' => $assetDetailsOnDate->timestamp,
                    'high' => $assetDetailsOnDate->highPrice,
                    'low' => $assetDetailsOnDate->lowPrice,
                    'close' => $assetDetailsOnDate->closePrice,
                    'open' => $assetDetailsOnDate->openPrice,
                    'trade_volume' => $assetDetailsOnDate->tradeVolume,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            AssetPrice::insertIgnore($assetPriceBuffer);
        }
    }
}
