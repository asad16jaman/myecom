<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
// $doUpload = function ($image) use ($directory, $code) {
//             $extention = $image->getClientOriginalExtension();
//             $imageName = $code . '_' . uniqId() . '.' . $extention;
//             $image->move($directory, $imageName);
//             return $directory . '/' . $imageName;
//         };

    public static function fileUpload($request,$image,$directory,$code=null){

        $doupload = function($image) use($directory,$code){
            $extension = $image->getClientOriginalExtension();
            $imageName = $code."_".uniqid().".".$extension;

            $image->move($directory,$imageName);
            return $directory."/".$imageName;
        };

        if($request->hasFile($image)){
            $file = $request->file($image);
            if(is_array($file) && count($file)){
                $filePath = [];
                foreach($file as $key=>$image){
                    $filePath[] = $doupload($image);
                }
                return $filePath;
            }else{
                return $doupload($file);
            }


        }

        return false;
    }

    public function s_Response($message,$data){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function e_Response($message,$data){
        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    






}
