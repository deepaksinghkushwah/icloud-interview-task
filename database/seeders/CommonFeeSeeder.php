<?php

namespace Database\Seeders;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\Commonfeecollection;
use App\Models\Commonfeecollectionheadwise;
use App\Models\EntryMode;
use App\Models\TempData;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommonFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** commmonfeecollections, commonfeecollectionheadwise */
        DB::disableQueryLog();
        $c = 0;
        DB::table('temp_data')->whereIn("voucher_type", ['RCPT', 'REVRCPT', 'JV', 'REVJV', 'PMT', 'REVPMT', 'Fundtransfer'])->groupBy(['admno_uniqueid'])->orderBy('id', 'asc')->chunk(100, function ($items) use (&$c) {
            $newTran = [];
            foreach ($items as $parent) {
                $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
                $branch = Branch::where('branch_name', $parent->faculty)->first();
                if (!$branch) {
                    continue;
                }
                $amountField = CommonHelper::getAmountField($parent->voucher_type);
                $amount = TempData::where([
                    'admno_uniqueid' => $parent->admno_uniqueid,
                ])->whereIn('voucher_type', ['RCPT', 'REVRCPT', 'JV', 'REVJV', 'PMT', 'REVPMT', 'Fundtransfer'])->sum($amountField);

                $moduleID = CommonHelper::getModuleID($parent->fee_head);
                // add entry in financialtran table
                $newTran[] = [
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
                Commonfeecollection::upsert($newTran, [
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
                    'inactive',
                ]);
                $c += 100;
                echo "Records created = {$c}\n";
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        });
    }
}
