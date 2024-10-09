<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commonfeecollectionheadwise extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'module_id',
        'receipt_id',
        'head_id',
        'head_name',
        'br_id',
        'amount'
    ];

}
