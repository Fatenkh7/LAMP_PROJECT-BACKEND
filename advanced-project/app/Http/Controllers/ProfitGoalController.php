<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfitGoal;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class ProfitGoalController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $ProfitGoal = ProfitGoal::paginate(5);
            return response()->json([
                'message' => $ProfitGoal
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving Profit Goals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getById(Request $request, $id)
    {
        try {
            $ProfitGoal = ProfitGoal::findOrFail($id);
            return response()->json([
                'message' => $ProfitGoal
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Profit Goal not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function getByTitle(Request $request, $title)
    {
        try {
            $ProfitGoal = ProfitGoal::where('goal_title', $title)->paginate(5);
            if ($ProfitGoal->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profit Goal not found'
                ], 404);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $ProfitGoal
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving ProfitGoal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function addProfitGoal(Request $request)
    {
        try {
            $this->validate($request, [
                'goal_title' => 'required|string|max:35',
                'goal_amount' => 'required|integer',
                'goal_description' => 'required|string|min:70|max:255',
                'admins_id' => 'required|exists:admins,id',
                'currencies_id' => 'required|exists:currencies,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $newProfitGoal = new ProfitGoal();
            $goal_title = $request->input('goal_title');
            $goal_amount = $request->input('goal_amount');
            $goal_description = $request->input('goal_description');
            $admins_id = $request->input('admins_id');
            $admins = Admin::find($admins_id);
            $currencies_id = $request->input('currencies_id');
            $currencies = Currency::find($currencies_id);
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $newProfitGoal->goal_title = $goal_title;
            $newProfitGoal->goal_amount = $goal_amount;
            $newProfitGoal->goal_description = $goal_description;
            $newProfitGoal->admins()->associate($admins);
            $newProfitGoal->currencies()->associate($currencies);
            $newProfitGoal->start_date = $start_date;
            $newProfitGoal->end_date = $end_date;

            $carbonDate = Carbon::parse($start_date);
            $carbonDate = Carbon::parse($end_date);

            $newProfitGoal->start_date = $carbonDate->format('Y-m-d H:i:s');
            $newProfitGoal->end_date = $carbonDate->format('Y-m-d H:i:s');

            $newProfitGoal->save();
            return response()->json([
                'message' => 'Profit goal created successfully'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function editprofitById(Request $request, $id)
    {
        try {
            // Check if the $id correct
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid profit goal ID'
                ], 400);
            }

            // Check if the profit_goal exists
            $profit_goal = ProfitGoal::find($id);
            if (!$profit_goal) {
                return response()->json([
                    'success' => false,
                    'message' => 'profit goal not found'
                ], 404);
            }

            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'goal_title' => 'required|string|max:35',
                'goal_amount' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the profit_goal
            $profit_goal->goal_title = $request->input('goal_title');
            $profit_goal->goal_amount = $request->input('goal_amount');
            $profit_goal->start_date = $request->input('start_date');
            $profit_goal->start_date = $request->input('end_date');
            $profit_goal->update();

            return response()->json([
                'success' => true,
                'message' => 'Profit goal updated successfully',
                'profit_goal' => $profit_goal,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error editing profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profit goal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editprofitByTitle(Request $request, $title)
    {
        try {
            $ProfitGoal = ProfitGoal::where('goal_title', $title)->first();
            if (!$ProfitGoal) {
                return response()->json([
                    'success' => false,
                    'message' => 'profit Goals not found',
                ], 404);
            }

            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'goal_title' => 'required|string|max:25',
                'goal_amount' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $inputs = $request->except('_method');
            $ProfitGoal->update($inputs);

            return response()->json([
                'success' => true,
                'message' => 'profit Goals updated successfully',
                'ProfitGoal' => $ProfitGoal,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error editing profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profit goal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteById(Request $request, $id)
    {
        try {
            $ProfitGoal = ProfitGoal::find($id);
            if (!$ProfitGoal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profit Goal not found'
                ], 404);
            }
            $ProfitGoal->delete();
            return response()->json([
                'success' => true,
                'message' => 'Profit Goal deleted successfully',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteByTitle(Request $request, $title)
    {
        try {
            $ProfitGoal = ProfitGoal::where('goal_title', $title)->delete();
            if (!$ProfitGoal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profit Goal(s) not found'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => $ProfitGoal . ' deleted successfully',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting profit goal from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Profit Goal(s)',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
