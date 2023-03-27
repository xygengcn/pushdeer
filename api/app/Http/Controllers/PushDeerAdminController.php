<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushDeerUser;
use App\Models\PushDeerKey;
use App\Models\PushDeerDevice;
use App\Models\PushDeerMessage;


class PushDeerAdminController extends Controller
{


    /**
     * 获取用户key
     */
    public function getUserPushKey(Request $request)
    {

        $validated = $request->validate(
            [
                'account' => 'string|required',
            ]
        );
    }
    /**
     * 拉取消息列表
     */
    public function messageAll()
    {
        $pd_message = PushDeerMessage::select('*')->limit(10)->get();
        return http_result(['list' => $pd_message], 200);
    }
}
