<?php

namespace App\Architect\AssetPriceProvider;


interface AssetPriceProvider
{
    /**
     * @param string $symbol A symbol to an asset, for example 'AAPL'
     * @return AssetPriceDetail[]
     */
    public function fetchHistoricalData(string $symbol): array;
}
