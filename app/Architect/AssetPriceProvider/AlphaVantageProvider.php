<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 05-Feb-19
 * Time: 11:12 PM
 */

namespace App\Architect\AssetPriceProvider;


use App\Architect\HTTPRequest\HTTPRequest;

class AlphaVantageProvider implements AssetPriceProvider
{

    /**
     * @param string $symbol A symbol to an asset, for example 'AAPL'
     * @return AssetPriceDetail[]
     */
    public function fetchHistoricalData(string $symbol): array
    {
        $wololo = (array)HTTPRequest::get("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$symbol&outputsize=full&apikey=" . env('ALPHAVANTAGE_KEY'));
        $timeSeriesKey = "Time Series (Daily)";
        $timeSeries = $downloadedHistory->$timeSeriesKey;
        return $wololo;
    }
}
