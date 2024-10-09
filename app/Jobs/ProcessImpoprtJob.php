<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImpoprtJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;
    public $timeout = 1200;

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
        $c = 0;
        while ($row = fgetcsv($filestram)) {
            if ($c <= 5) {
                $c++;
                continue;
            }
            dispatch(new ProcessDataImportJob($row, $mapping))->onQueue('importProcess');
        }
        fclose($filestram);
        unlink($this->filepath);
    }
}
