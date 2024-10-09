<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImpoprtJob;
use App\Models\TempData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function importForm()
    {
        return view('import.form');
    }
    public function processCsvImport(Request $request)
    {
        $validate = $request->validate([
            'csv' => 'required|file|mimetypes:text/csv'
        ]);

        $file = $request->file('csv');


        $storeFile = $file->store('csv', 'public');
        dispatch(new ProcessImpoprtJob(storage_path('app/public/' . $storeFile)))->onQueue('import');
        return redirect()->route('import.result')->with('success', 'CSV has been processed successfully');
    }

    public function importResult()
    {
        
        return view('import.result');
    }

    public function resultVerify(){
        return view('import.verify',[
            'totalRecords' => TempData::count(),
            'due_amount' => DB::table('temp_data')->sum('due_amount'),
            'concession_amount' => DB::table('temp_data')->sum('concession_amount'),
            'paid_amount' => DB::table('temp_data')->sum('paid_amount'),
            'scholarship_amount' => DB::table('temp_data')->sum('scholarship_amount'),
            'reverse_concession_amount' => DB::table('temp_data')->sum('reverse_concession_amount'),
            'write_off_amount' => DB::table('temp_data')->sum('write_off_amount'),
            'adjusted_amount' => DB::table('temp_data')->sum('adjusted_amount'),
            'refund_amount' => DB::table('temp_data')->sum('refund_amount'),
            'fund_trancfer_amount' => DB::table('temp_data')->sum('fund_trancfer_amount'),

        ]);
    }
}
