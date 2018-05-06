<?php
/**
 * User: yemeishu
 * Date: 2018/4/7
 * Time: 下午12:13
 */

namespace App\Common;

use \App\Xpath as XpathModel;
use Symfony\Component\DomCrawler\Crawler;

class Xpath {

    public static function analysis(XpathModel $model) {
        $html = file_get_contents($model->url);

        $crawler = new Crawler($html);

        $titlenodes = $crawler->filterXPath($model->titlexpath);
        $titles = self::getValueByNodes($titlenodes, $model->titlevalue);

        $descnodes = $crawler->filterXPath($model->descxpath);
        $desces = self::getValueByNodes($descnodes, $model->descvalue);

        $urlnodes = $crawler->filterXPath($model->urlxpath);
        $urls = self::getValueByNodes($urlnodes, $model->urlvalue);

        return RssFeeds::feeds($model, $titles, $desces, $urls);
    }

    // 通过规则获取 nodes 的值
    public static function getValueByNodes(Crawler $crawler, $key = null) {
        return $crawler->each(function (Crawler $node) use ($key) {
            if (empty($key)) {
                return trim($node->text());
            }
            // 去掉 else 的效果
                return $node->attr($key);
        });
    }
}