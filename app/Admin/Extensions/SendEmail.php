<?php
/**
 * User: yemeishu
 * Date: 2018/6/11
 * Time: 下午9:54
 */

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class SendEmail
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-sendemail-row').on('click', function () {

    // Your code.
    console.log($(this).data('id'));

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs btn-success fa fa-check grid-sendemail-row' data-id='{$this->id}'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}