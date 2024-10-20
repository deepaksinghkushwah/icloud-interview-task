<?php

namespace Database\Seeders;

use App\Http\Helpers\CommonHelper;
use App\Models\Branch;
use App\Models\Commonfeecollection;
use App\Models\Commonfeecollectionheadwise;
use App\Models\EntryMode;
use App\Models\Financialtran;
use App\Models\Financialtrandetail;
use App\Models\TempData;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
