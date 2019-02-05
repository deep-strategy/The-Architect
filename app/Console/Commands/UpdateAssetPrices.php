<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\AssetPrice;
use App\Architect\HTTPRequest\HTTPRequest;
use Symfony\Component\Console\Output\ConsoleOutput;

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $output = new ConsoleOutput();
        $assets = Asset::all();

        $assetBar = $this->output->createProgressBar(count($assets));
        $assetBar->start();

        foreach ($assets as $asset) {
            $downloadedHistory = HTTPRequest::get("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$asset->symbol&outputsize=full&apikey=" . env('ALPHAVANTAGE_KEY'));
            $timeSeriesKey = "Time Series (Daily)";
            $timeSeries = $downloadedHistory->$timeSeriesKey;
            $timeSeriesBar = $this->output->createProgressBar(count((array) $timeSeries));
            $output->write("\n");
            $timeSeriesBar->start();
            foreach ($timeSeries as $date => $assetDetailsOnDate) {
                AssetPrice::create([
                    'asset_id' => $asset->id,
                    'timestamp' => $date,   
                    'price' => $assetDetailsOnDate->{'4. close'},
                    'trade_volume' => $assetDetailsOnDate->{'5. volume'},
                ]);
                $timeSeriesBar->advance();
            }
            $timeSeriesBar->finish();
            $output->write("\033[1A");
            $assetBar->advance();
        }
        $assetBar->finish();
    }
}
