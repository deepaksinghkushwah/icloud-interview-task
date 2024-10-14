<?php

namespace App\Jobs;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\Commonfeecollection;
use App\Models\Commonfeecollectionheadwise;
use App\Models\EntryMode;
use App\Models\TempData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportCommonFeeWithDetails implements ShouldQueue
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
        /** commmonfeecollections, commonfeecollectionheadwise */
        $trans = DB::select("SELECT voucher_no, voucher_type,faculty, roll_no,fee_head,admno_uniqueid, academic_year, `session`,receipt_no, transaction_date FROM `temp_data` WHERE voucher_type IN ('RCPT','REVRCPT','JV','REVJV','PMT','REVPMT','Fundtransfer') GROUP by `voucher_no`,`admno_uniqueid`, `transaction_date`");
        
        foreach ($trans as $parent) {
            $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
            $branch = Branch::where('branch_name', $parent->faculty)->first();
            if(!$branch){
                Log::info("Branch not found");
                Log::info(json_encode($parent));
                continue;
            }
            $amountField = CommonHelper::getAmountField($parent->voucher_type);
            $amount = TempData::where([
                'voucher_no'=> $parent->voucher_no,
                'admno_uniqueid' => $parent->admno_uniqueid,
                'transaction_date' =>$parent->transaction_date,
                'receipt_no' => $parent->receipt_no,
            ])->sum($amountField);
            $moduleID = CommonHelper::getModuleID($parent->fee_head);
            // add entry in financialtran table
            $newTran = Commonfeecollection::create([
                'moduleid' => $moduleID,
                'transid' => CommonHelper::generateTransId(12),
                'admno' => $parent->admno_uniqueid,
                'rollno' => $parent->roll_no,
                'amount' => $amount,
                'br_id' => $branch->id,
                'acadamic_year' => $parent->academic_year,
                'financial_year' => $parent->session,
                'display_receipt_no' => $parent->receipt_no,
                'entrymode' => $entryMod->entrymodeno,
                'paid_date' => $parent->transaction_date,                
                'inactive' => CommonHelper::getInactive($entryMod->entry_modename),    
            ]);

            // add child entries in 
            $trandetails = DB::select("SELECT * FROM `temp_data` WHERE voucher_no ='" . $parent->voucher_no . "'");
            foreach ($trandetails as $trandetail) {
                $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
                Commonfeecollectionheadwise::create([
                    'module_id' => $moduleID,
                    'receipt_id' =>  $newTran->id,
                    'head_id' => 1,
                    'head_name' => $parent->fee_head,
                    'br_id' => $branch->id,
                    'amount' => $trandetail->{$amountField},
                ]);
            }
        }
    }
}
