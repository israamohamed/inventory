<?php 
function responseJson($status , $message , $data = []) 
{
    $arr = [
        'status' => $status,
        'message' => $message,
        'data'   => $data,
    ];

    return response()->json($arr , 200);
}