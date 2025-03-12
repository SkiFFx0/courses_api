<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class ApiResponse extends Model
{
    public static function success($message = "OK", $data = null)
    {
        if(!$data){
            $data = new stdClass();
        }
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => 1,
        ]);
    }

    public static function error($message, $data = null, $code = 500)
    {
        if(!$data){
            $data = new stdClass();
        }
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => 0,
        ], $code);
    }
}
