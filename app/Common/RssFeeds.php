<?php
/**
 * User: yemeishu
 * Date: 2018/4/7
 * Time: 下午2:41
 */

namespace App\Common;

use App\Xpath;
use Carbon\Carbon;

class RssFeeds {
    public static function feeds(Xpath $xpath, $titles = [], $desces = [], $urls = []) {
        if (!empty($xpath->preurl)) {
            $preurl = $xpath->preurl;
            $urlss = collect($urls)->map(function ($url, $key) use ($preurl) {
                return $preurl.trim($url);
            });
        } else {
            $urlss = collect($urls);
        }
        return response()
            ->view('rss',
            [
                'xpath' => $xpath,
                'titles' => $titles,
                'desces' => $desces,
                'urls' => $urlss->toArray(),
                'pubDate' => Carbon::now()
            ])
            ->header('Content-Type', 'text/xml');
    }
}