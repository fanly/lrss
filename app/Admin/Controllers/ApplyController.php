<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\SendEmail;
use App\Apply;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ApplyController extends Controller
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

            $content->header('申请列表');
            $content->description('来自多用户申请');

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
        return Admin::grid(Apply::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('user_id', '申请人id');
            $grid->column('user.name', '申请人');
            $grid->column('user.email', '申请人Email')->popover('right');

            $grid->column('url', '申请链接');
            $grid->column('interval', '更新间隔时间')
                ->display(function ($interval) {
                return config('app.interval_options')[$interval];
            });

            $grid->column('remark', '申请备注');

            // 看是否已关联已有的 rss
            $grid->column('xpath_id', 'rss id');

            // 看是否已发邮件了
            $grid->column('hassent', '发送邮箱')
                ->display(function ($hassent)
                {
                    if ($hassent === 0) {
                        return "<span class='label label-warning'>$hassent</span>";
                    }

                    return "<span class='label label-success'>$hassent</span>";
                }
            );

            $grid->created_at();
            $grid->updated_at();

            $grid->actions(function ($actions) {
                $user_id = $actions->row->user_id;
                $xpath_id = $actions->row->user_id;
                $url = "emails/create?user_id=$user_id&xpath_id=$xpath_id";

                $actions->prepend('<a href="'.$url.'"><i class="fa fa-paper-plane"></i></a>');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Apply::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
