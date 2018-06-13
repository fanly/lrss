<?php

namespace App\Admin\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function users(Request $request) {
        $q = $request->get('q');
        return User::where('name', 'like', "%$q%")
            ->paginate(null, ['id', 'email as text']);
    }
}
