<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['fee_category_id','f_name','collection_id','br_id','seq_id','fee_type_ledger','fee_headtype'];
}
