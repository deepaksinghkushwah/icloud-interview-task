<?php

namespace App\Jobs;

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

class ProcessImpoprtJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $filepath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mapping = [
            'sr' => 0,
            'transaction_date' => 1,
            'academic_year' => 2,
            'session' => 3,
            'alloted_category' => 4,
            'voucher_type' => 5,
            'voucher_no' => 6,
            'roll_no' => 7,
            'admno_uniqueid' => 8,
            'status' => 9,
            'fee_category' => 10,
            'faculty' => 11,
            'program' => 12,
            'department' => 13,
            'batch' => 14,
            'receipt_no' => 15,
            'fee_head' => 16,
            'due_amount' => 17,
            'paid_amount' => 18,
            'concession_amount' => 19,
            'scholarship_amount' => 20,
            'reverse_concession_amount' => 21,
            'write_off_amount' => 22,
            'adjusted_amount' => 23,
            'refund_amount' => 24,
            'fund_trancfer_amount' => 25,
            'remark' => 26,
        ];

        $filestram = fopen($this->filepath, 'r');
        $arr = [];
        $c = 0;
        while ($row = fgetcsv($filestram, 1024)) {
            if ($c <= 5) {
                $c++;
                continue;
            }
            $transactionDate = Carbon::parse($this->convertToUTF8($row[$mapping['transaction_date']]))->format('Y-m-d');
            $arr[] = [
                'transaction_date' => $transactionDate,
                'academic_year' => $this->convertToUTF8($row[$mapping['academic_year']]),
                'session' => $this->convertToUTF8($row[$mapping['session']]),
                'alloted_category' => $this->convertToUTF8($row[$mapping['alloted_category']]),
                'voucher_type' => $this->convertToUTF8($row[$mapping['voucher_type']]),
                'voucher_no' => $this->convertToUTF8($row[$mapping['voucher_no']]),
                'roll_no' => $this->convertToUTF8($row[$mapping['roll_no']]),
                'admno_uniqueid' => $this->convertToUTF8($row[$mapping['admno_uniqueid']]),
                'status' => $this->convertToUTF8($row[$mapping['status']]),
                'fee_category' => $this->convertToUTF8($row[$mapping['fee_category']]),
                'faculty' => $this->convertToUTF8($row[$mapping['faculty']]),
                'program' => $this->convertToUTF8($row[$mapping['program']]),
                'department' => $this->convertToUTF8($row[$mapping['department']]),
                'batch' => $this->convertToUTF8($row[$mapping['batch']]),
                'receipt_no' => $this->convertToUTF8($row[$mapping['receipt_no']]),
                'fee_head' => $this->convertToUTF8($row[$mapping['fee_head']]),
                'due_amount' => (float)($row[$mapping['due_amount']]) ?? 0.00,
                'paid_amount' => (float)($row[$mapping['paid_amount']]) ?? 0.00,
                'concession_amount' => (float)($row[$mapping['concession_amount']]) ?? 0.00,
                'scholarship_amount' => (float)($row[$mapping['scholarship_amount']]) ?? 0.00,
                'reverse_concession_amount' => (float)($row[$mapping['reverse_concession_amount']]) ?? 0.00,
                'write_off_amount' => (float)($row[$mapping['write_off_amount']]) ?? 0.00,
                'adjusted_amount' => (float)($row[$mapping['adjusted_amount']]) ?? 0.00,
                'refund_amount' => (float)($row[$mapping['refund_amount']]) ?? 0.00,
                'fund_trancfer_amount' => (float)($row[$mapping['fund_trancfer_amount']]) ?? 0.00,
                'remark' => $this->convertToUTF8($row[$mapping['remark']]),

            ];
        }
        fclose($filestram);
        unlink($this->filepath);

        $chunks = array_chunk($arr, 1000);
        //Log::info($chunks[0]);
        foreach ($chunks as $chunk) {
            //Log::info($chunk);
            try {
                TempData::upsert($chunk, [
                    'transaction_date',
                    'academic_year',
                    'session',
                    'alloted_category',
                    'voucher_type',
                    'voucher_no',
                    'roll_no',
                    'admno_uniqueid',
                    'status',
                    'fee_category',
                    'faculty',
                    'program',
                    'department',
                    'batch',
                    'receipt_no',
                    'fee_head',
                    'due_amount',
                    'paid_amount',
                    'concession_amount',
                    'scholarship_amount',
                    'reverse_concession_amount',
                    'write_off_amount',
                    'adjusted_amount',
                    'refund_amount',
                    'fund_trancfer_amount',
                    'remark'
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Log::info($chunk);
                break;
            }
        }
    }

    private function convertToUTF8($str)
    {
        $str = preg_replace('/[\x00-\x1F\x7F]/', '', $str);
        $str = str_replace(['�', '+'], '', $str);
        $str = htmlentities($str, ENT_QUOTES, 'UTF-8');
        $str = addslashes($str);
        $enc = mb_detect_encoding($str);

        if ($enc && $enc != 'UTF-8') {
            return iconv($enc, 'UTF-8', $str);
        } else {
            return $str;
        }
    }
}
