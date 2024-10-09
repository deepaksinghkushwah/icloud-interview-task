<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['category','br_id'];

    public function branch(){
        return $this->belongsTo(Branch::class,'br_id','id');
    }
}
