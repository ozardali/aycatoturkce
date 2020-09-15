<?php

namespace App\Http\Controllers;

use App\Translation;
use Carbon\Carbon;
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
    public function createTranslate(Request $request)
    {

        if($request->text == null || $request->translate == null){
            return response()->json('Boş veri gönderilemez.', 202);
        }
        $is_exist = Translation::where('ayca', $request->text)->first();

        if($is_exist){
            return response()->json('Böyle bir çeviri zaten veritabanında mevcut', 200);
        }
        $now = Carbon::now();
        $newTranslate = new Translation();
        $newTranslate->ayca = $request->text;
        $newTranslate->turkce = $request->translate;
        $newTranslate->status = false;
        $newTranslate->created_at = $now;
        $newTranslate->updated_at = $now;
        $newTranslate->save();
        return response()->json('Çeviri başarıyla yollandı, değerlendirme sonrasında veritabanında aktif olacaktır.', 201);
    }
    public function getList(){
        $list = Translation::where('status',true)->get();
        return response()->json($list, 200);
    }
}
