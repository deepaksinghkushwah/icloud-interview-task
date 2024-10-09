<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCollectionType extends Model
{
    use HasFactory;
    protected $fillable = ['collection_head','collection_desc','br_id'];
    public $timestamps = false;

    public function branch(){
        return $this->belongsTo(Branch::class,'br_id','id');
    }
}
