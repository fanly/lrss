<?php

namespace App\Http\Controllers;

use App\Common\Xpath;
use Illuminate\Http\Request;
use App\Xpath as XpathModel;

class RssController extends Controller
{

    /*
     * 获取所有已有的 rss 列表
     * return []
     */
    public function index()
    {
        return  $this->output(200, '数据返回成功', ['list' => XpathModel::all()]);
    }

    public function show($id)
    {
        $model = Xpath::find($id);
        return Xpath::analysis($model);
    }
}
