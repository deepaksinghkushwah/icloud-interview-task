<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Commonfeecollection;
use App\Models\Commonfeecollectionheadwise;
use App\Models\EntryMode;
use App\Models\Financialtran;
use App\Models\Financialtrandetail;
use App\Models\TempData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        /** entrymode */
        // $arr = [
        //     ['DUE', 'D','0'],
        //     ['REVDUE', 'C','12'],
        //     ['SCHOLARSHIP', 'C','15'],
        //     ['REVSCHOLARSHIP/REVCONCESSION', 'D','16'],
        //     ['CONCESSION', 'C','15'],
        //     ['RCPT', 'C','0'],
        //     ['REVRCPT', 'D','0'],
        //     ['JV', 'C','14'],
        //     ['REVJV', 'D','14'],
        //     ['PMT', 'D','1'],
        //     ['REVPMT', 'C','1'],
        //     ['Fundtransfer', '+ ve and -ve','1'],            
        // ];

        // foreach($arr as $row){
        //     EntryMode::create([
        //         'entry_modename' => $row[0],
        //         'crdr' => $row[1],
        //         'entrymodeno' => $row[2]
        //     ]);
        // }

        /** Modules */
        // $arr = [
        //     ['academic', 1],
        //     ['academicmisc', 11],
        //     ['hostel', 2],            
        //     ['hostelmisc', 22],
        //     ['transport', 3],
        //     ['transportmisc', 33],
        // ];

        // foreach($arr as $row){
        //     Module::create([
        //         'module_name' => $row[0],
        //         'module_id' => $row[1],                
        //     ]);
        // }

        /** branches */
        // $branches = DB::select('SELECT DISTINCT(faculty) FROM `temp_data`');
        // foreach($branches as $row){
        //     Branch::create([
        //         'branch_name' => $row->faculty
        //     ]);
        // }

        /** fee_categories */
        // $categories = ['General','NON SAARC NRI','SAARC NRI' ];
        // $branches = Branch::all();
        // foreach($branches as $branch){
        //     foreach($categories as $cat){
        //         FeeCategory::create([
        //             'category' => $cat,
        //             'br_id' => $branch->id
        //         ]);
        //     }
        // }

        /** fee_collection_types */
        // $arr = [
        //     'academic',
        //      'academicmisc',
        //      'hostel',            
        //      'hostelmisc',
        //      'transport',
        //      'transportmisc',
        // ];
        // $branches = Branch::all();
        // foreach($branches as $branch){
        //     foreach($arr as $row){
        //         FeeCollectionType::create([
        //             'collection_head' => $row,
        //             'collection_desc' => $row,
        //             'br_id' => $branch->id,
        //         ]);
        //     }
        // }

        /** Fee_types */
        // $feeheads = DB::select('SELECT DISTINCT(fee_head) FROM `temp_data`');
        // $branches = Branch::all();
        // foreach ($feeheads as $key => $head) {
        //     foreach ($branches as $branch) {
        //         $headtype = '';
        //         if(stristr($head->fee_head, 'fine') != false){
        //             $headtype = 11;
        //         } elseif(stristr($head->fee_head, 'mess') != false){
        //             $headtype = 2;
        //         } else {
        //             $headtype = 1;
        //         }

        //         //echo $headtype."\n";
        //         FeeType::create([
        //             'fee_category_id' => 1,
        //             'f_name' => $head->fee_head,
        //             'collection_id' => 1,
        //             'br_id' => $branch->id,
        //             'seq_id' => $key,
        //             'fee_type_ledger' => $head->fee_head,
        //             'fee_headtype' => $headtype,
        //         ]);
        //     }
        // }

        /** finaicialtrans, finalcialtrandetails */
        // $trans = DB::select("SELECT DISTINCT(voucher_no), voucher_type,faculty FROM `temp_data` WHERE voucher_type IN ('DUE','REVDUE','SCHOLARSHIP','REVSCHOLARSHIP/REVCONCESSION','CONCESSION') limit 1000");

        // foreach ($trans as $parent) {
        //     $tempRecord = TempData::where('voucher_no', $parent->voucher_no)->first();
        //     $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
        //     $branch = Branch::where('branch_name', $parent->faculty)->first();
        //     //$amount = DB::select("SELECT SUM(due_amount) FROM temp_data WHERE voucher_no = '" . $parent->voucher_no . "'");
        //     $amountField = $this->getAmountField($parent->voucher_type);

        //     $amount = TempData::where('voucher_no', $parent->voucher_no)->sum($amountField);

        //     $toc = null;
        //     if ($tempRecord->voucher_type == 'CONCESSION') {
        //         $toc = 1;
        //     } elseif ($tempRecord->voucher_type == 'SCHOLARSHIP') {
        //         $toc = 2;
        //     } else {
        //         $toc = null;
        //     }

        //     $moduleID = 1;
        //     if (stristr($tempRecord->fee_head, 'fine') != false) {
        //         $moduleID = 11;
        //     } elseif (stristr($tempRecord->fee_head, 'mess') != false) {
        //         $moduleID = 2;
        //     } else {
        //         $moduleID = 1;
        //     }
        //     // add entry in financialtran table
        //     $newTran = Financialtran::create([
        //         'moduleid' => $moduleID,
        //         'transid' => $this->generateTransId(12),
        //         'admno' => $tempRecord->admno_uniqueid,
        //         'amount' => $amount,
        //         'crdr' => $entryMod->crdr,
        //         'trandate' => $tempRecord->transaction_date,
        //         'acadyear' => $tempRecord->academic_year,
        //         'entrymodeno' => $entryMod->entrymodeno,
        //         'voucherno' => $parent->voucher_no,
        //         'br_id' => $branch->id,
        //         'type_of_concession' => $toc,
        //     ]);

        //     // add child entries in 
        //     $trandetails = DB::select("SELECT * FROM `temp_data` WHERE voucher_no ='" . $parent->voucher_no . "'");
        //     foreach ($trandetails as $trandetail) {
        //         $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
        //         Financialtrandetail::create([
        //             'financial_trans_id' => $newTran->id,
        //             'module_id' => $moduleID,
        //             'amount' => $trandetail->{$amountField},
        //             'head_id' => 1,
        //             'crdr' => $entryMod->crdr,
        //             'br_id' => $branch->id,
        //             'head_name' => $trandetail->fee_head,
        //         ]);
        //     }
        // }

        /** commmonfeecollections, commonfeecollectionheadwise */
        $trans = DB::select("SELECT DISTINCT(voucher_no), voucher_type,faculty, roll_no FROM `temp_data` WHERE voucher_type IN ('RCPT','REVRCPT','JV','REVJV','PMT','REVPMT','Fundtransfer') limit 1000");
        foreach ($trans as $parent) {
            $tempRecord = TempData::where('voucher_no', $parent->voucher_no)->first();
            $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
            $branch = Branch::where('branch_name', $parent->faculty)->first();
            $amountField = $this->getAmountField($parent->voucher_type);

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
            $newTran = Commonfeecollection::create([
                'moduleid' => $moduleID,
                'transid' => $this->generateTransId(12),
                'admno' => $tempRecord->admno_uniqueid,
                'rollno' => $parent->roll_no,
                'amount' => $amount,
                'br_id' => $branch->id,
                'acadamic_year' => $tempRecord->academic_year,
                'financial_year' => $tempRecord->session,
                'display_receipt_no' => $tempRecord->receipt_no,
                'entrymode' => $entryMod->entrymodeno,
                'paid_date' => $tempRecord->transaction_date,                
                'inactive' => $parent->voucher_no,    
            ]);

            // add child entries in 
            $trandetails = DB::select("SELECT * FROM `temp_data` WHERE voucher_no ='" . $parent->voucher_no . "'");
            foreach ($trandetails as $trandetail) {
                $entryMod = EntryMode::where('entry_modename', $parent->voucher_type)->first();
                Commonfeecollectionheadwise::create([
                    'module_id' => $moduleID,
                    'receipt_id' =>  $newTran->id,
                    'head_id' => 1,
                    'head_name' => $tempRecord->fee_head,
                    'br_id' => $branch->id,
                    'amount' => $trandetail->{$amountField},
                ]);
            }
        }
    }

    private function generateTransId($length)
    {
        $number = '';
        do {
            for ($i = $length; $i--; $i > 0) {
                $number .= mt_rand(0, 9);
            }
        } while (!empty(DB::table('financialtrans')->where('transid', $number)->first(['transid'])));

        return $number;
    }

    private function getAmountField(string $voucherType): string
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
