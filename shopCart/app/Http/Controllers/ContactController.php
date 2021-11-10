<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ContactController extends Controller
{
    /**
     * 發送聯絡我們訊息
     * 
     * @param array $msg
     * @return null
     */
    public function sendMessage(Request $msg){
        Redis::publish('contactUs', json_encode([
            'message'=>$msg->all(),
        ]));

        return redirect()->back();
    }
}
