<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financialtrandetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['financial_trans_id','module_id','amount','head_id','crdr','br_id','head_name'];
}
