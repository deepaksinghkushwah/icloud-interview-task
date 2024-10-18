<?php

namespace App\Jobs;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\EntryMode;
use App\Models\Financialtran;
use App\Models\Financialtrandetail;
use App\Models\TempData;
use Carbon\Carbon;
use Exception;
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
        $trans = DB::select("SELECT * FROM `temp_data` WHERE voucher_type IN ('DUE','REVDUE','SCHOLARSHIP','REVSCHOLARSHIP/REVCONCESSION','CONCESSION') GROUP BY `admno_uniqueid`");

        foreach ($trans as $parent) {
            //$tempRecord = TempData::where('admno_uniqueid', $parent->admno_uniqueid)->first();
            $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
            //dd($entryMod);
            $branch = Branch::where('branch_name', $parent->faculty)->first();
            if (!$branch) {
                Log::info("Financialtran: Branch not found");
                Log::info(json_encode($parent));
                continue;
            }
            $amountField = CommonHelper::getAmountField($parent->voucher_type);
            $amount = TempData::where('admno_uniqueid', $parent->admno_uniqueid)->sum($amountField);

            $toc = CommonHelper::getToc($parent->voucher_type);
            $moduleID = CommonHelper::getModuleID($parent->fee_head);
            
            // add entry in financialtran table
            try {
                $newTran = Financialtran::create([
                    'moduleid' => $moduleID,
                    'transid' => CommonHelper::generateTransId(12),
                    'admno' => $parent->admno_uniqueid,
                    'amount' => $amount,
                    'crdr' => $entryMod->crdr,
                    'trandate' => $parent->transaction_date,
                    'acadyear' => $parent->academic_year,
                    'entrymodeno' => (int)$entryMod->entrymodeno,
                    'voucherno' => $parent->voucher_no,
                    'br_id' => $branch->id ?? 1,
                    'type_of_concession' => $toc,
                ]);

                // add child entries in 
                $trandetails = DB::select("SELECT * FROM `temp_data` WHERE admno_uniqueid ='" . $parent->admno_uniqueid . "'");
                foreach ($trandetails as $trandetail) {
                    $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
                    Financialtrandetail::create([
                        'financial_trans_id' => $newTran->id,
                        'module_id' => $moduleID,
                        'amount' => $trandetail->{$amountField},
                        'head_id' => 1,
                        'crdr' => $entryMod->crdr,
                        'br_id' => $branch->id ?? 1,
                        'head_name' => $trandetail->fee_head,
                    ]);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Log::info(json_encode([
                    'moduleid' => $moduleID,
                    'transid' => CommonHelper::generateTransId(12),
                    'admno' => $parent->admno_uniqueid,
                    'amount' => $amount,
                    'crdr' => $entryMod->crdr,
                    'trandate' => $parent->transaction_date,
                    'acadyear' => $parent->academic_year,
                    'entrymodeno' => (int)$entryMod->entrymodeno,                    
                    'br_id' => $branch->id ?? 1,
                    'type_of_concession' => $toc,
                ]));
            }
        }
    }
}
