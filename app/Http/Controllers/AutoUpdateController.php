<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutoUpdateController extends Controller {
    
    public function __construct($secret) {
        if (env('AUTO_SECRET') != $secret) {
            return false;
        }
    }

    public function index() {
        
    }


}
