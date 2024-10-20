<?php

namespace Database\Seeders;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\EntryMode;
use App\Models\Financialtran;
use App\Models\Financialtrandetail;
use App\Models\TempData;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FinancialTransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** finaicialtrans, finalcialtrandetails */
        $trans = DB::select("SELECT * FROM `temp_data` WHERE voucher_type IN ('DUE','REVDUE','SCHOLARSHIP','REVSCHOLARSHIP/REVCONCESSION','CONCESSION') GROUP BY `admno_uniqueid`");
        $c = 0;
        $total = count($trans);
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
                $c++;
                echo "{$c} records processed out of {$total}\n";
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
