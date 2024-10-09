<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commonfeecollection extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'moduleid',
        'transid',
        'admno',
        'rollno',
        'amount',
        'br_id',
        'acadamic_year',
        'financial_year',
        'display_receipt_no',
        'entrymode',
        'paid_date',
        'inactive'
    ];

}
