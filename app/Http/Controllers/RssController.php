<?php

namespace App\Http\Controllers;

use App\Common\Xpath;
use Illuminate\Http\Request;
use App\Xpath as XpathModel;
use Illuminate\Pagination\LengthAwarePaginator;

class RssController extends Controller
{

    /*
     * 获取所有已有的 rss 列表
     * return []
     */
    public function index(Request $request)
    {
        $from = $request->input('from', 0);

        if ($from == 1) {
            $all_rss = $request->user()->xpaths()->get();
        } else {
            $all_rss = XpathModel::all();
        }

        $current_page = $request->input('current_page', 1);
        $per_page = $request->input('per_page', 3);

        $items = $all_rss->forPage($current_page, $per_page);

        $paginate = new LengthAwarePaginator($items, $all_rss->count(), $per_page, $current_page);

        return  $this->output(200, '数据返回成功', ['rss' => $paginate]);
    }

    public function show($id)
    {
        $model = XpathModel::find($id);
        return Xpath::analysis($model);
    }
}
