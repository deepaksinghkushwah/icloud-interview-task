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

    public static function getToc($voucherType): int|null
    {
        $toc = null;
        if ($voucherType == 'CONCESSION') {
            $toc = 1;
        } elseif ($voucherType == 'SCHOLARSHIP') {
            $toc = 2;
        } else {
            $toc = null;
        }
        return $toc;
    }

    public static function getModuleID($feeHead): int
    {
        $moduleID = 1;
        if (stristr($feeHead, 'fine') != false) {
            $moduleID = 11;
        } elseif (stristr($feeHead, 'mess') != false) {
            $moduleID = 2;
        } else {
            $moduleID = 1;
        }

        return $moduleID;
    }

    public static function getInactive($type): int|null
    {
        $ret = 0;
        switch ($type) {
            case 'RCPT':
                $ret = 0;
                break;
            case 'REVRCPT':
                $ret = 1;
                break;
            case 'JV':
                $ret = 0;
                break;
            case 'REVJV':
                $ret = 1;
                break;
            case 'PMT':
                $ret = 0;
                break;
            case 'REVPMT':
                $ret = 1;
                break;
            default:
                $ret = null;
        }
        return $ret;
    }
}
