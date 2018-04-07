![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231095285999.jpg)

> Wait no longer! Create RSS feeds for all websites you care about and read them from the comfort of your feed reader.
> 

现在越来越多的网站都不支持 RSS 订阅了，而作为 RSS 的忠实粉丝，还是希望有个工具可以将自己关注的网站内容聚合在一起，然后实时推送到手机上，及时获取最新消息和新闻动态。

所以今天就让我们用 2 个小时，撸一个 RSS 生成器。

本文的主角仍然是 Laravel。

## 1. 搭建 Laravel 骨架

由于需要有一个后台，添加我们关注的网站，所以我们还是沿用 laravel-damin 插件。

```bash
// 1. 创建 Laravel 5.5版本项目

composer create-project --prefer-dist laravel/laravel:5.5 lrss

cd lrss

cp .env.example .env

php artisan key:generate

// 2. 使用 laravel-admin 插件
composer require encore/laravel-admin "1.5.*"

php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

php artisan admin:install

```

*注：*如出现问题：SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes 

解决方案：在 `AppServiceProvider.php` 加入默认字符串长度

```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```


刚巧，我们想借助 Symfonys 提供的 `DomCrawler` 插件，来解析网站的 xpath 信息，发现 `laravel-admin`插件有引入：

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15230742085390.jpg)

## 2. 解析 XPath

之前有想借助 huginn 这个神器来生成我们的 RSS Feed，主要参看文章：让所有网页变成RSS —— Huginn [http://git.huginn.cn/docs/%E8%AE%A9%E6%89%80%E6%9C%89%E7%BD%91%E9%A1%B5%E5%8F%98%E6%88%90RSS%E2%80%94%E2%80%94Huginn.html](http://git.huginn.cn/docs/%E8%AE%A9%E6%89%80%E6%9C%89%E7%BD%91%E9%A1%B5%E5%8F%98%E6%88%90RSS%E2%80%94%E2%80%94Huginn.html)

但在实际使用中，发现一直出现 Huginn 无故宕机，或者后台 jobs 动不动就失败。这才有了自己撸个工具的想法。

但 Huginn 给了我灵感，可以利用解析 XPath 来生成 RSS Feed。

### 创建 Xpath 控制器

为了验证输入的 XPath 信息的准确性，我们可以参考 Huginn，

首先在 Huginn 测试 XPath 的效果，在创建 WebsiteAgent 界面，输入如下信息：

```json
{
  "expected_update_period_in_days": "2",
  "url": "http://www.woshipm.com/",
  "type": "html",
  "mode": "on_change",
  "extract": {
    "title": {
      "xpath": "//div[@class=\"postlist-item u-clearfix\"]/div[2]/h2/a/text()",
      "value": "normalize-space(.)"
    },
    "desc": {
      "xpath": 
"//div[@class=\"postlist-item u-clearfix\"]/div[2]/p/text()",
      "value": "normalize-space(.)"
    },
    "url": {
      "xpath": "//div[@class=\"postlist-item u-clearfix\"]/div[2]/h2/a",
      "value": "@href"
    }
  }
}
```

然后点 「Dry Run」即可测试：

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231065259761.jpg)

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231065682480.jpg)

最后根据 Huginn 填入的信息，我们来创建 Xpath Controller

```php
// bash
php artisan make:model Xpath -m

// migration
public function up()
{
    Schema::create('xpaths', function (Blueprint $table) {
        $table->increments('id');
        
        // url
        $table->string('url', 250);
        $table->string("urldesc", 250);
        
        // title
        $table->string('titlexpath', 250);
        $table->string('titlevalue', 100)
              ->nullable();

        // desc
        $table->string('descxpath', 250);
        $table->string('descvalue', 100)
               ->nullable();

        // url
        $table->string("preurl", 50)->nullable();
        
        $table->string('urlxpath', 250);
        $table->string('urlvalue', 100)
              ->nullable();
              
        $table->timestamps();
    });
}

// migrate
php artisan migrate

// 创建 admin/Controller
php artisan admin:make XpathController --model=App\\Xpath

// 建立 route
$router->resource('xpaths', XpathController::class);

// 加入到 admin 的 menu 中
// 略
```
*注：* 可以参考之前的文章：[推荐一个 Laravel admin 后台管理插件](http://mp.weixin.qq.com/s/PnAj0j2X3-lq3Mn06qjIdQ)

### CURD XPath

有了 laravel-admin 插件，操作 XPath 信息就好简单了，直接看代码：

```php
<?php

namespace App\Admin\Controllers;

use App\Xpath;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class XpathController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Xpath::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('url');
            $grid->column('urldesc', "描述");

            $grid->column('titlexpath');
            $grid->column('titlevalue');

            $grid->column('descxpath');
            $grid->column('descvalue');

            $grid->column('preurl');
            $grid->column('urlxpath');
            $grid->column('urlvalue');

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Xpath::class, function (Form $form) {

            $form->display('id', 'ID');

            // url
            $form->text('url', '链接')
                ->placeholder('请输入解析的网址')
                ->rules('required|min:5|max:250');

            $form->text('urldesc', '一句话描述')
                ->placeholder('一句话描述')
                ->rules('required|min:5|max:250');

            // title
            $form->divide();
            $form->text('titlexpath', 'title xpath')
                ->placeholder('请输入标题 xpath')
                ->rules('required|min:5|max:250');

            $form->text('titlevalue', 'title value 默认可以不填')
                ->default('')
                ->rules('max:100');

            // desc
            $form->divide();
            $form->text('descxpath', 'desc xpath')
                ->placeholder('请输入详情 xpath')
                ->rules('required|min:5|max:250');

            $form->text('descvalue', 'desc value，默认可以不填')
                ->default('')
                ->rules('max:100');

            // url
            $form->divide();
            $form->text('preurl', 'url 前缀')
                ->placeholder('请输入文章的url 前缀')
                ->rules('max:50');

            $form->text('urlxpath', 'url xpath')
                ->placeholder('请输入文章的url xpath')
                ->rules('required|min:5|max:250');

            $form->text('urlvalue', 'url value 默认可以不填')
                ->default('')
                ->rules('max:100');

            $form->divide();
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

```

添加两个网站信息试试：

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231070228449.jpg)

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231069651606.jpg)

### XPath 转为 RSS Feed

*1.* 根据填入的 Xpath 信息，解析内容：

```php
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
        } else {
            return $node->attr($key);
        }
    });
}
```

*2.* 将获得 title、desc 和 url 数组装入 Feed Item 中，构建 RSS。

```php
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
```
 
 *3.* 编写 blade 模板
 
 ```php
 <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $xpath->url or ' title' }}</title>
        <description>{{ $xpath->urldesc or '描述' }}</description>
        <link>{{ $xpath->url }}</link>
        <atom:link href="{{ url("/feed/$xpath->id") }}" rel="self" type="application/rss+xml"/>
        <pubDate>{{ $pubDate }}</pubDate>
        <lastBuildDate>{{ $pubDate }}</lastBuildDate>
        <generator>coding01</generator>
        @foreach ($titles as $key => $title)
            <item>
                <title>{{ $title }}</title>
                <link>{{ $urls[$key] }}</link>
                <description>{{ $desces[$key] }}</description>
                <pubDate>{{ $pubDate }}</pubDate>
                <author>coding01</author>
                <guid>{{ $urls[$key] }}</guid>
                <category>{{ $title }}</category>
            </item>
        @endforeach
    </channel>
</rss>
 ```

*4.* 最终来看看效果吧，为每一个网站做成一个 RSS：

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231048364333.jpg)

## RSS 实时订阅

至此，当前的 Laravel 代码告一段落了，但为了达到及时推送内容到手机的目标，我借助了两个工具：

> 1. Tiny Tiny RSS
> 2. IFTTT + 钉钉

把制作好的 RSS 链接加入 Tiny Tiny RSS 上，每隔半个小时，更新一次，获取最新的内容：

![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231083165344.jpg)

然后借助 IFTTT 绑定钉钉的群机器人 Webhook：

![iftttout](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-iftttout.png)

最后在手机钉钉或者在 PC 上就能及时收到最新资讯和信息了：


![](http://ow20g4tgj.bkt.clouddn.com/2018-04-07-15231091214839.jpg)

## 总结

今天花了 2 个小时，主要是借助 laravel-amin 和 symfony/dom-crawler 插件来自己动手搭建一个 RSS Feed 生成工具Demo。

接下来还有待于继续优化，如向 [https://feed43.com/](https://feed43.com/) 那样，输入 Web URL 就能生成 RSS Feed，又能根据实际需要自己设定更新时间等。

最后，代码以放在 github 上，可供参考: [https://github.com/fanly/lrss](https://github.com/fanly/lrss)

**「未完待续」**

