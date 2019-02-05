<?php

namespace App\Models;


class AssetPrice extends BaseModel
{
    protected $fillable = [
		'asset_id',
		'price',
		'trade_volume',
		'timestamp',
	];
}
