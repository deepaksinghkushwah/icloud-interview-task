<?php

use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use App\Jobs\ImportCommonFeeWithDetailsV2;
use App\Jobs\ImportTransWithDetails;
use App\Models\TempData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/import-data', [ImportController::class, 'importForm'])->name('import.showForm');

    Route::post('/import-data-process', [ImportController::class, 'processCsvImport'])->name('import.processCsvImport');

    Route::get('/import-result', [ImportController::class, 'importResult'])->name('import.result');

    Route::get('/result-verify', [ImportController::class, 'resultVerify'])->name('import.resultVerify');

    Route::get('/process-other-queue', [ImportController::class, 'processTransAndFee'])->name('import.processTransAndFee');

    Route::get('/financial-transactions', [FinancialTransactionController::class, 'index'])->name('financialtran.index');

    Route::get('process', function () {
        $rows = TempData::whereIn("voucher_type", ['RCPT', 'REVRCPT', 'JV', 'REVJV', 'PMT', 'REVPMT', 'Fundtransfer'])->groupBy(['voucher_no','admno_uniqueid','transaction_date'])->chunk(1000, function(Collection $rows){
            dispatch(new ImportCommonFeeWithDetailsV2($rows))->onQueue('ImportCommonFeeWithDetailsV2');
        });        
        
    });

    Route::get('test', function(){
        $rows = TempData::whereIn("voucher_type", ['DUE','REVDUE','SCHOLARSHIP','REVSCHOLARSHIP/REVCONCESSION','CONCESSION'])->groupBy(['admno_uniqueid']);
        echo $rows->toSql();
        // TempData::whereIn("voucher_type", ['DUE','REVDUE','SCHOLARSHIP','REVSCHOLARSHIP/REVCONCESSION','CONCESSION'])->groupBy(['admno_uniqueid'])->chunk(500, function(Collection $rows){
        //     dispatch(new ImportTransWithDetails($rows))->onQueue('ImportTransWithDetails');
        // });        
    });
});
