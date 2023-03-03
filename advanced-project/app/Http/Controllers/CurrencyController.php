<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
//for example, if the database connection is lost or...
use Illuminate\Database\QueryException;

class CurrencyController extends Controller
{
    public function getAll()
    {
        try {
            $currencies = Currency::paginate(5);
            return response()->json([
                'message' => $currencies
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving currencies from database'
            ]);
        }
    }

    public function getCurrencyById(Request $request, $id)
    {
        try {
            $currency = Currency::find($id);
            if ($currency) {
                return response()->json([
                    'success' => true,
                    'data' => $currency
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'This currency not found'
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving currency from database'
            ]);
        }
    }

    public function addCurrency(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'currency' =>  'required|string|unique:currencies',
                'rate' => 'required|integer',
            ]);

            $currency = new Currency($validatedData);
            $currency->save();

            return response()->json([
                'message' => 'Currency created successfully'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding currency to database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // public function editCurrencyById(Request $request, $id)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'currency' => ['required','string', 'unique:currencies'],
    //             'rate' => ['required|integer'],
    //         ]);

    //         $currency = Currency::find($id);
    //         $currency->fill($validatedData);
    //         $currency->save();

    //         return response()->json([
    //             'message' => 'Currency updated successfully',
    //             'report' => $currency,
    //         ]);
    //     } catch (QueryException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error updating currency in database'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }

    public function editCurrencyById(Request $request, $id) {
        try {
            // Check if the id is valid
            if (!is_numeric($id) | !$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Currency ID'
                ], 400);
            }

            // Check if Admin exists
            $currencies = Currency::find($id);
            if (!$currencies) {
                return response()->json([
                    'success' => false,
                    'message' => 'Currency not found'
                ], 404);
            }

            // Data validation 
            $data = $request->only('currency','rate');
            $validator = Validator::make($data, [
                'currency'=>'required|string|unique:currencies',
                'rate'=>'required|integer',

            ]);
            if($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $currencies = Currency::find($id);
            $currency = $request->input('currency');
            $rate = $request->input('rate');
            

            $currencies->currency = $currency;
            $currencies->rate = $rate;
            

            $currencies->update();
            // $inputs = $request->except('_method');
            // $admin->update($inputs);


            return response()->json([
                'message' => 'Currency updated successfully',
                'Currency' => $currencies,
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteCurrency(Request $request, $id)
    {
        try {
            $currency = Currency::find($id);
            $currency->delete();

            return response()->json([
                'message' => 'Currency deleted successfully',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting currency from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
