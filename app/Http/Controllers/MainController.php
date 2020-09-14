<?php

namespace App\Http\Controllers;

use App\Translation;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //

    public function translate(Request $request){


        $response = Translation::where('ayca', $request->text)->where('status',true)->first();

        if($response){
            return response()->json($response, 200);
        }
        else{
            return response()->json('hata', 202);
        }

    }
}
