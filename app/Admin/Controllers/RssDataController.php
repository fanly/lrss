<?php

namespace App\Admin\Controllers;

use App\RssData;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RssDataController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RssData);

        $grid->id('Id');
        $grid->title('Title');
        $grid->author('Author');
        $grid->type('Type');
        $grid->content('Content');
        $grid->url('Url');
        $grid->imageUrl('ImageUrl');
        $grid->published('Published');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RssData::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->author('Author');
        $show->type('Type');
        $show->content('Content');
        $show->url('Url');
        $show->imageUrl('ImageUrl');
        $show->published('Published');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RssData);

        $form->text('title', 'Title');
        $form->text('author', 'Author');
        $form->text('type', 'Type');
        $form->textarea('content', 'Content');
        $form->url('url', 'Url');
        $form->text('imageUrl', 'ImageUrl');
        $form->text('published', 'Published');

        return $form;
    }
}
