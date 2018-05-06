<?php

namespace App\Admin\Controllers;

use App\User;
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

            $grid->column('user.name', '归属人');

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

            $form->select('interval', '更新间隔时间')->options(
                [
                1 => '一个小时', 
                2 => '两个小时',
                4 => '四个小时', 
                8 => '八个小时',
                12 => '半天',
                ]
            );

            $form->select('user_id')->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->name];
                }
            })->ajax('/admin/users');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
