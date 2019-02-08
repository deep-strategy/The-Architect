<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 05-Feb-19
 * Time: 11:12 PM
 */

namespace App\Architect\AssetPriceProvider;


use App\Architect\HTTPRequest\HTTPRequest;
use Carbon\Carbon;

class AlphaVantageProvider implements AssetPriceProvider
{

    /**
     * @param string $symbol A symbol to an asset, for example 'AAPL'
     * @return AssetPriceDetail[]
     */
    public function fetchHistoricalData(string $symbol): array
    {
        $timeSeries = $this->downloadFromAPI($symbol);
        $historicalData = $this->formatTimeSeries($timeSeries);
        return $historicalData;
    }

    protected function formatTimeSeries(array $timeSeries): array
    {
        $historicalData = [];
        foreach ($timeSeries as $timestamp => $value) {
            $historicalData[] = $this->valueToAssetPriceDetail($timestamp, $value);
        }
        return $historicalData;
    }

    private function valueToAssetPriceDetail($timestamp, $value): AssetPriceDetail
    {
        return new AssetPriceDetail(
            new Carbon($timestamp),
            $value->{"1. open"},
            $value->{"4. close"},
            $value->{"2. high"},
            $value->{"3. low"},
            $value->{"5. volume"});
    }

    private function constructRequestUri($symbol): string
    {
        return "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$symbol&outputsize=full&apikey=" . config('services.alphavantage.key');
    }

    private function downloadFromAPI(string $symbol): array
    {
        $downloadedHistory = HTTPRequest::get($this->constructRequestUri($symbol));
        $timeSeries = (array)$downloadedHistory->{"Time Series (Daily)"};
        return $timeSeries;
    }
}
