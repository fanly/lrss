<?php

namespace App\Http\Controllers;

use App\Apply;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $from = $request->input('from', 0);

        if ($from == 1) {
            $all_apply = $request->user()->applies()->get();
        } else {
            $all_apply = Apply::all();
        }

        $current_page = $request->input('current_page', 1);
        $per_page = $request->input('per_page', 3);

        $items = $all_apply->forPage($current_page, $per_page);

        $paginate = new LengthAwarePaginator($items, $all_apply->count(), $per_page, $current_page);

        return  $this->output(200, '数据返回成功', ['apply' => $paginate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->filled(['url', 'interval'])) {
            return $this->output(501, "缺少必要的参数");
        }
        $url = $request->input('url');

        $remark = $request->input('remark', '');

        $apply = Apply::firstOrCreate([
            'url' => $url,
            'user_id' => $request->user()->id
        ], [
           'interval' => $request->input('interval'),
            'remark' => $remark
        ]);

        if ($apply) {
            return $this->output(200,
                "创建数据成功: $apply->id",
                ['apply' => $apply]);
        }

        return $this->output(502, '创建失败');
    }
}
