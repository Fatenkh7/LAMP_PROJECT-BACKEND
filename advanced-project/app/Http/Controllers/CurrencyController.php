<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function getAll()
    {
        $Currency = Currency::all();
        return response()->json([
            'message' => $Currency
        ]);
    }

    public function getCurrencyById(Request $Request, $id)
    {
        $Currency = Currency::find($id);
        if ($Currency) {
            return response()->json([
                'success' => true,
                'data' => $Currency
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
        $newCurrency = new Currency();
        $currency = $request->input('currency');
        $newCurrency->currency = $currency;
        $newCurrency->save();
        return response()->json([
            'message' => 'Currency created successfully'
        ]);
    }

    public function editCurrencyById(Request $request, $id)
    {
        $Currency = Currency::find($id);
        $inputs = $request->except('_method');
        $Currency->update($inputs);

        return response()->json([
            'message' => 'Currency updated successfully',
            'report' => $Currency,
        ]);
    }

    public function deleteCurrency(Request $request, $id)
    {
        $Currency = Currency::find($id);
        $Currency->delete();
        return response()->json([
            'message' => 'Currency deleted successfully',
        ]);
    }
}
