<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PushDeerMessage;


class PushDeerAdminController extends Controller
{


    /**
     * 获取用户key
     * 
     * 参数:邮箱 账号
     */
    public function getUserPushKey(Request $request)
    {

        $validated = $request->validate(
            [
                'account' => 'string|required',
                'email' => 'string|nullable'
            ]
        );
        $result = DB::select('SELECT k.`key`,k.`name` AS pushName,u.`name` AS account FROM push_deer_keys k JOIN push_deer_users u ON k.uid=u.id WHERE u.`name`= ? OR u.email= ? LIMIT 1;', [$validated['account'], $validated['email']]);
        return http_result($result, 200);
    }
    /**
     * 拉取消息列表
     */
    public function messageAll(Request $request)
    {
        $validated = $request->validate(
            [
                'pageIndex' => 'integer|nullable',
                'pageNum' => 'integer|nullable'
            ]
        );
        $pageIndex = $validated['pageIndex'] - 1 > 0 ? $validated['pageIndex'] : 0;
        $pageNum = $validated['pageNum'] || 15;
        $result = DB::select('SELECT a.id,a.uid,u.NAME,a.TEXT,a.desp,a.type,a.created_at,a.updated_at FROM push_deer_messages a JOIN push_deer_users u ON a.uid=u.id ORDER BY a.updated_at DESC LIMIT ? OFFSET ?', [$pageNum, $pageIndex * $pageNum]);
        return http_result($result, 200);
    }
}
