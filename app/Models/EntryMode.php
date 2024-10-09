<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryMode extends Model
{
    //use HasFactory;
    protected $fillable = ['entry_modename','crdr','entrymodeno'];
    public $timestamps = false;
}
