<?php

namespace App\Http\Controllers;

use App\RssData;
use Illuminate\Http\Request;

class RssDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证是否正确
        if ($request->input('token', '') !== env('RSS_DATA_SECRET')) {
            return $this->output(401, "token 信息错误");
        }

        $rssData = new RssData();

        $rssData->title = $request->input('title', '');
        $rssData->author = $request->input('author', '');
        $rssData->type = $request->input('type', '');
        $rssData->content = $request->input('content', '');
        $rssData->url = $request->input('url', '');
        $rssData->imageUrl = $request->input('imageUrl', '');
        $rssData->published = $request->input('published', '');

        $saved = $rssData->save();

        if ($saved) {
            return $this->output(200, "保存成功", ['data' => $rssData]);
        } else {
            return $this->output(402, "存储失败");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RssData  $rssData
     * @return \Illuminate\Http\Response
     */
    public function show(RssData $rssData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RssData  $rssData
     * @return \Illuminate\Http\Response
     */
    public function edit(RssData $rssData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RssData  $rssData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RssData $rssData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RssData  $rssData
     * @return \Illuminate\Http\Response
     */
    public function destroy(RssData $rssData)
    {
        //
    }
}
