<?php

namespace App\Jobs;

use App\Models\TempData;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDataImportJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct(private array $rowData, private array $mapping)
  {
    try {
      $transactionDate = Carbon::parse($this->convertToUTF8($this->rowData[$this->mapping['transaction_date']]))->format('Y-m-d');
      TempData::create(
        [
          'transaction_date' => $transactionDate ,
          'academic_year' => $this->convertToUTF8($this->rowData[$this->mapping['academic_year']]),
          'session' => $this->convertToUTF8($this->rowData[$this->mapping['session']]),
          'alloted_category' => $this->convertToUTF8($this->rowData[$this->mapping['alloted_category']]),
          'voucher_type' => $this->convertToUTF8($this->rowData[$this->mapping['voucher_type']]),
          'voucher_no' => $this->convertToUTF8($this->rowData[$this->mapping['voucher_no']]),
          'roll_no' => $this->convertToUTF8($this->rowData[$this->mapping['roll_no']]),
          'admno_uniqueid' => $this->convertToUTF8($this->rowData[$this->mapping['admno_uniqueid']]),
          'status' => $this->convertToUTF8($this->rowData[$this->mapping['status']]),
          'fee_category' => $this->convertToUTF8($this->rowData[$this->mapping['fee_category']]),
          'faculty' => $this->convertToUTF8($this->rowData[$this->mapping['faculty']]),
          'program' => $this->convertToUTF8($this->rowData[$this->mapping['program']]),
          'department' => $this->convertToUTF8($this->rowData[$this->mapping['department']]),
          'batch' => $this->convertToUTF8($this->rowData[$this->mapping['batch']]),
          'receipt_no' => $this->convertToUTF8($this->rowData[$this->mapping['receipt_no']]),
          'fee_head' => $this->convertToUTF8($this->rowData[$this->mapping['fee_head']]),
          'due_amount' => $this->convertToUTF8($this->rowData[$this->mapping['due_amount']]),
          'paid_amount' => $this->convertToUTF8($this->rowData[$this->mapping['paid_amount']]),
          'concession_amount' => $this->convertToUTF8($this->rowData[$this->mapping['concession_amount']]),
          'scholarship_amount' => $this->convertToUTF8($this->rowData[$this->mapping['scholarship_amount']]),
          'reverse_concession_amount' => $this->convertToUTF8($this->rowData[$this->mapping['reverse_concession_amount']]),
          'write_off_amount' => $this->convertToUTF8($this->rowData[$this->mapping['write_off_amount']]),
          'adjusted_amount' => $this->convertToUTF8($this->rowData[$this->mapping['adjusted_amount']]),
          'refund_amount' => $this->convertToUTF8($this->rowData[$this->mapping['refund_amount']]),
          'fund_trancfer_amount' => $this->convertToUTF8($this->rowData[$this->mapping['fund_trancfer_amount']]),
          'remark' => $this->convertToUTF8($this->rowData[$this->mapping['remark']]),
        ],

      );
    } catch (\Exception $e) {
      //dd($e->getMessage(), json_encode($this->rowData));
      Log::error($e->getMessage());
      Log::info($this->rowData);
    }
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    //
  }

  private function convertToUTF8($str) {
    $str = preg_replace('/[\x00-\x1F\x7F]/', '', $str);
    $str = addslashes($str);
    $enc = mb_detect_encoding($str);

    if ($enc && $enc != 'UTF-8') {
        return iconv($enc, 'UTF-8', $str);
    } else {
        return $str;
    }
  }
}
