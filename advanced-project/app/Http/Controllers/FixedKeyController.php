<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedKey;
use Illuminate\Support\Facades\Validator;

class FixedKeyController extends Controller
{   
    public function addFixedKey (Request $request){

        try{

        $data = $request->only('name', 'description', 'is_active');
        $validator = Validator::make($data, [

            "name"=>'required|string',
            "description"=>'required|string',
            "is_active"=>'required|boolean',

        ]);
        if($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return $errors;
        }

        $Fixedkey = new FixedKey;

        $Fixedkey->name = $request->input('name');
        $Fixedkey->description = $request->input('description');
        $Fixedkey->is_active = $request->input('is_active');



        $Fixedkey->save();

        return response()->json([
            'message' => 'fixed key created successfully',
        ]);}
        catch(\Exception $e){
            return $e -> getMessage();
        }
    }
    public function getFixedkey (){

        try{

        $FixedKey =FixedKey::all();

        return response()->json([
            'message'=>$FixedKey
        ]);
    }
    catch(\Exception $e){
        return $e -> getMessage();
    }
    }

    public function getbyidFixedkey ($id){

        try{

        $FixedKey =FixedKey::find($id);

        return response()->json([
            'message'=>$FixedKey
        ]);
    }
    catch(\Exception $e){
        return $e -> getMessage();
    }
    }



    public function editFixedkey (Request $request ,$id){
        try{

        $FixedKey =FixedKey::find ($id);

        $inputs = $request->except('_method');

        $FixedKey->update($inputs);

        return response()->json([
            'message'=>'fixed key is updated',
            'result'=>$FixedKey
        ]);
    }
    catch(\Exception $e){
        return $e -> getMessage();
    }

    }

    public function deleteFixedkey ($id){

        try{

        $FixedKey =FixedKey::find ($id);
        $FixedKey->delete();

        return response()->json([
            'message'=>'delete successfully'
        ]);
    }
    catch(\Exception $e){
        return $e -> getMessage();
    }
    }


}
