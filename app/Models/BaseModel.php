<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @method static insertOnDuplicateKey (array $data, array $columnsToUpdate)
 * @method static insertIgnore (array $data)
 */
class BaseModel extends Model
{
    protected $guarded = [];
}
