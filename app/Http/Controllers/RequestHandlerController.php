<?php

namespace App\Http\Controllers;

use App\Jobs\ResponseJob;
use Illuminate\Http\Request;

class RequestHandlerController extends Controller
{
    public function index(Request $request,$index)
    {
        \Log::info('request: '.$index,[$request->getUri()]);

        dispatch(new ResponseJob($request->getUri()));

        return response()->json(['message'=>'Received request with index #'.$index]);
    }
}
