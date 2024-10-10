<?php

namespace App\Jobs;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\EntryMode;
use App\Models\Financialtran;
use App\Models\Financialtrandetail;
use App\Models\TempData;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportTransWithDetails implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** finaicialtrans, finalcialtrandetails */
        $trans = DB::select("SELECT DISTINCT(voucher_no), voucher_type,faculty FROM `temp_data` WHERE voucher_type IN ('DUE','REVDUE','SCHOLARSHIP','REVSCHOLARSHIP/REVCONCESSION','CONCESSION')");

        foreach ($trans as $parent) {
            $tempRecord = TempData::where('voucher_no', $parent->voucher_no)->first();
            $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
            //dd($entryMod);
            $branch = Branch::where('branch_name', $parent->faculty)->first();
            $amountField = CommonHelper::getAmountField($parent->voucher_type);
            $amount = TempData::where('voucher_no', $parent->voucher_no)->sum($amountField);

            $toc = null;
            if ($tempRecord->voucher_type == 'CONCESSION') {
                $toc = 1;
            } elseif ($tempRecord->voucher_type == 'SCHOLARSHIP') {
                $toc = 2;
            } else {
                $toc = null;
            }

            $moduleID = 1;
            if (stristr($tempRecord->fee_head, 'fine') != false) {
                $moduleID = 11;
            } elseif (stristr($tempRecord->fee_head, 'mess') != false) {
                $moduleID = 2;
            } else {
                $moduleID = 1;
            }
            // add entry in financialtran table
            $newTran = Financialtran::create([
                'moduleid' => $moduleID,
                'transid' => CommonHelper::generateTransId(12),
                'admno' => $tempRecord->admno_uniqueid,
                'amount' => $amount,
                'crdr' => $entryMod->crdr,
                'trandate' => $tempRecord->transaction_date,
                'acadyear' => $tempRecord->academic_year,
                'entrymodeno' => (int)$entryMod->entrymodeno,
                'voucherno' => $parent->voucher_no,
                'br_id' => $branch->id,
                'type_of_concession' => $toc,
            ]);

            // add child entries in 
            $trandetails = DB::select("SELECT * FROM `temp_data` WHERE voucher_no ='" . $parent->voucher_no . "'");
            foreach ($trandetails as $trandetail) {
                $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
                Financialtrandetail::create([
                    'financial_trans_id' => $newTran->id,
                    'module_id' => $moduleID,
                    'amount' => $trandetail->{$amountField},
                    'head_id' => 1,
                    'crdr' => $entryMod->crdr,
                    'br_id' => $branch->id,
                    'head_name' => $trandetail->fee_head,
                ]);
            }
        }
    }

    
}
