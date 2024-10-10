<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;

class CommonHelper
{
    public static function generateTransId($length)
    {
        $number = '';
        do {
            for ($i = $length; $i--; $i > 0) {
                $number .= mt_rand(0, 9);
            }
        } while (!empty(DB::table('financialtrans')->where('transid', $number)->first(['transid'])));

        return $number;
    }

    public static function getAmountField(string $voucherType): string
    {
        if ($voucherType == 'DUE') {
            $amountField = 'due_amount';
        } else if ($voucherType == 'REVDUE') {
            $amountField = 'write_off_amount';
        } else if ($voucherType == 'SCHOLARSHIP') {
            $amountField = 'scholarship_amount';
        } else if ($voucherType == 'REVSCHOLARSHIP/REVCONCESSION') {
            $amountField = 'reverse_concession_amount';
        } else if ($voucherType == 'CONCESSION') {
            $amountField = 'concession_amount';
        } else if ($voucherType == 'RCPT') {
            $amountField = 'paid_amount';
        } else if ($voucherType == 'REVRCPT') {
            $amountField = 'paid_amount';
        } else if ($voucherType == 'JV') {
            $amountField = 'adjusted_amount';
        } else if ($voucherType == 'REVJV') {
            $amountField = 'adjusted_amount';
        } else if ($voucherType == 'PMT') {
            $amountField = 'refund_amount';
        } else if ($voucherType == 'REVPMT') {
            $amountField = 'refund_amount';
        } else if ($voucherType == 'Fundtransfer') {
            $amountField = 'fund_trancfer_amount';
        } else {
            $amountField = 'due_amount';
        }

        return $amountField;
    }
}
