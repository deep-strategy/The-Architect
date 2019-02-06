<?php

namespace App\Architect\AssetPriceProvider;


use Carbon\Carbon;

class AssetPriceDetail
{
    /**
     * @var Carbon
     */
    public $timestamp;
    /**
     * @var float
     */
    public $openPrice;
    /**
     * @var float
     */
    public $closePrice;
    /**
     * @var float
     */
    public $highPrice;
    /**
     * @var float
     */
    public $lowPrice;
    /**
     * @var int
     */
    public $tradeVolume;

    /**
     * AssetPriceDetail constructor.
     */
    public function __construct(Carbon $timestamp, float $openPrice, float $closePrice, float $highPrice, float $lowPrice, int $tradeVolume)
    {
        $this->timestamp = $timestamp;
        $this->openPrice = $openPrice;
        $this->closePrice = $closePrice;
        $this->highPrice = $highPrice;
        $this->lowPrice = $lowPrice;
        $this->tradeVolume = $tradeVolume;
    }
}
