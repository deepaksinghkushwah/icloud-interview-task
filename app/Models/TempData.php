<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_date',
        'academic_year',
        'session',
        'alloted_category',
        'voucher_type',
        'voucher_no',
        'roll_no',
        'admno_uniqueid',
        'status',
        'fee_category',
        'faculty',
        'program',
        'department',
        'batch',
        'receipt_no',
        'fee_head',
        'due_amount',
        'paid_amount',
        'concession_amount',
        'scholarship_amount',
        'reverse_concession_amount',
        'write_off_amount',
        'adjusted_amount',
        'refund_amount',
        'fund_trancfer_amount',
        'remark'
    ];
}
