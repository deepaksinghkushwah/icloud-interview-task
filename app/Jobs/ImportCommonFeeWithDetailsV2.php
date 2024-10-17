<?php

namespace App\Jobs;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\Commonfeecollection;
use App\Models\EntryMode;
use App\Models\TempData;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportCommonFeeWithDetailsV2 implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Collection $rows)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transArr = [];
        foreach ($this->rows as $parent) {
            $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
            $branch = Branch::where('branch_name', $parent->faculty)->first();
            if (!$branch) {
                continue;
            }
            $amountField = CommonHelper::getAmountField($parent->voucher_type);
            $amount = TempData::where([
                'voucher_no' => $parent->voucher_no,
                'admno_uniqueid' => $parent->admno_uniqueid,
                'transaction_date' => $parent->transaction_date,
                'receipt_no' => $parent->receipt_no,
            ])->sum($amountField);
            $moduleID = CommonHelper::getModuleID($parent->fee_head);
            // add entry in financialtran table
            $transArr[] = [
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
            ];
        }


        try {
            Commonfeecollection::upsert($transArr, [
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
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
