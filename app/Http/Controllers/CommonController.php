<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    function getTimeline(Request $request){
        $page=$request->get('page',1);
        $pageSize=$request->get('pageSize',15);
        $data= common_ins()->getTimeline($page,$pageSize);
        return ['status'=>1,'data'=>$data];
    }
}
