<?php

namespace App\Architect\AssetPriceProvider;


interface AssetPriceProvider
{
    /**
     * @param string $symbol A symbol to an asset, for example 'AAPL'
     * @param string $frequency
     * @return AssetPriceDetail[]
     */
    public function fetchHistoricalData(string $symbol, string $frequency): array;
}
