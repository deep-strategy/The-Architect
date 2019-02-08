<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 05-Feb-19
 * Time: 11:16 PM
 */

namespace Tests\Unit\Architect\AssetPriceProvider;


use App\Architect\AssetPriceProvider\AssetPriceDetail;
use App\Architect\AssetPriceProvider\AssetPriceProvider;
use Carbon\Carbon;

class TestProvider implements AssetPriceProvider
{

    /**
     * @param string $symbol A symbol to an asset, for example 'AAPL'
     * @return AssetPriceDetail[]
     */
    public function fetchHistoricalData(string $symbol): array
    {
        return [
            new AssetPriceDetail(Carbon::today(), 10, 5, 15, 3, 1000),
            new AssetPriceDetail(Carbon::yesterday(), 4.5, 9.5, 10, 4, 5201),
        ];
    }
}
