<?php

namespace App\Admin\Controllers;

use App\Email;

use App\Mail\RssCreated;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
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

            $content->header('发送邮箱提醒列表');
            $content->description('汇总邮箱发送列表');

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

            $content->header('修改');
            $content->description('修改发送内容等');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Request $request)
    {
        $user_id = $request->input('user_id', null);
        $xpath_id = $request->input('xpath_id', null);

        return Admin::content(function (Content $content) use ($user_id, $xpath_id) {

            $content->header('创建邮箱');
            $content->description('创建邮箱发送');

            $content->body($this->form($user_id, $xpath_id));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Email::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('user_id', '申请人id');
            $grid->column('user.name', '申请人');
            $grid->column('user.email', '申请人Email')->popover('right');
            $grid->column('content', '邮箱内容');

            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($user_id = null, $xpath_id = null)
    {
        return Admin::form(Email::class, function (Form $form) use ($user_id, $xpath_id) {

            $form->display('id', 'ID');

            if ($user_id == null) {
                $form->select('user_id', 'email')->options(function ($id) {
                    $user = User::find($id);

                    if ($user) {
                        return [$user->id => $user->email];
                    }
                })->ajax('/admin/users');
            } else {
                $form->select('user_id', 'email')->options(function ($id) use ($user_id) {
                    $user = User::find($user_id);

                    if ($user) {
                        return [$user->id => $user->email];
                    }
                });
            }
            $form->divide();
            $form->textarea('content', '邮件内容')
                ->rows(10);
            $form->divide();

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saved(function (Form $form) {
                Mail::to($form->model()->user->email)->send(new RssCreated($form->model()));
            });
        });
    }
}
