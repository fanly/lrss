<?php

namespace App\Http\Controllers;

use App\Common\Xpath;
use Illuminate\Http\Request;

class RssController extends Controller {

    public function index($id) {
        $model = \App\Xpath::find($id);
        return Xpath::analysis($model);
    }
}
