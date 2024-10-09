<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImpoprtJob;
use Exception;
use Illuminate\Http\Request;

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
}
