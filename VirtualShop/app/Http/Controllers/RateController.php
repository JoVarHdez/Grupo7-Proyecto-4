<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate;
use Auth;

class RateController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        
            
        //$option = json_decode($request);
        if (Auth::check())
        {
            Rate::where("idProduct", $request -> input('idProduct'))
                 -> where("idUser", $request -> input('idUser'))
                 -> delete();

            $newRate =  Rate::create([
                'idUser' => $request -> input('idUser'),
                'idProduct' => $request -> input('idProduct'),
                'rate' => $request -> input('rate'),
            ]);
            
                        
            $ratesSum = Rate::where("idProduct", $request -> input('idProduct'))
                        -> sum("rate");

            $rateCount = Rate::where("idProduct", $request -> input('idProduct'))
                        -> count();

    

            $data = array(
                "rate" => $newRate -> rate,
                "ratesCount" => $rateCount,
                "ratesSum" => $ratesSum
            );

            return \Response::json($data); 
        }

            
        $error = array(
            "msg" => "error"
        );

        
        return \Response::json($error);    
    }
}
