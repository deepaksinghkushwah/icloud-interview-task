<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financialtran extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['moduleid','transid','admno','amount','crdr','trandate','acadyear','entrymodnp','voucherno','br_id','type_of_concession'];
}
