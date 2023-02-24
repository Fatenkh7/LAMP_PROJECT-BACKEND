<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currencies;
class CurrenciesController extends Controller
{
    public function getAll(){
        $currencies = Currencies::all();
        return response()->json([
            'message' => $currencies
        ]);
    }

    public function getCurrencyById(Request $Request, $id){
        $currencies = Currencies::find($id)->get();
        if ($currencies) {
            return response()->json([
                'success' => true,
                'data' => $currencies
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This currency not found'
            ]);
        }
    }

    public function addCurrency(Request $request)
    {
        $newCurrency = new Currencies();
        $currency = $request->input('currency');
        $newCurrency->currency = $currency;
        $newCurrency->save();
        return response()->json([
            'message' => 'Currency created successfully'
        ]);
    }

}
