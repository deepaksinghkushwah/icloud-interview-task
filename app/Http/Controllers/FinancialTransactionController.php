<?php

namespace App\Http\Controllers;

use App\Models\Financialtran;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index(Request $request){
        
        $query = Financialtran::query();
        if($request->voucher_no){
            $query->where('voucherno', $request->voucher_no);
        }
        $items = $query->paginate(25);
        //dd($items);
        return view('financialtran.index',['items' => $items]);
    }
}
