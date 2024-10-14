<?php

use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/process-other-queue',[ImportController::class,'processTransAndFee'])->name('import.processTransAndFee');

    Route::get('/financial-transactions',[FinancialTransactionController::class,'index'])->name('financialtran.index');
});
