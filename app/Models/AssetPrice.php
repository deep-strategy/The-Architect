<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class AssetPrice
 * @property int $id
 * @property float $open
 * @property float $close
 * @property float $high
 * @property float $low
 * @property int $volume
 * @property Carbon $timestamp
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AssetPrice extends BaseModel
{
}
