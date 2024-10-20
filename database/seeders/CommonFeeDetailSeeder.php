<?php

namespace Database\Seeders;

use App\Http\Helpers\CommonHelper;
use App\Models\Commonfeecollection;
use App\Models\Commonfeecollectionheadwise;
use App\Models\EntryMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommonFeeDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog();
        Commonfeecollection::chunk(10, function ($items) {
            $arr = [];            
            foreach ($items as $parent) {
                $trandetails = DB::select("SELECT * FROM `temp_data` WHERE `admno_uniqueid` = '{$parent->admno_uniqueid}' AND voucher_type IN ('RCPT','REVRCPT','JV','REVJV','PMT','REVPMT','Fundtransfer')");
                foreach ($trandetails as $trandetail) {
                    $entryMod = EntryMode::where('entry_modename', $trandetail->voucher_type)->first();
                    $amountField = CommonHelper::getAmountField($trandetail->voucher_type);
                    $arr[] = [
                        'module_id' => $parent->moduleid,
                        'receipt_id' =>  $parent->id,
                        'head_id' => 1,
                        'head_name' => $trandetail->fee_head,
                        'br_id' => $parent->br_id,
                        'amount' => $trandetail->{$amountField},
                    ];
                }                
            }           
            Commonfeecollectionheadwise::insert($arr);
        });
    }
}
