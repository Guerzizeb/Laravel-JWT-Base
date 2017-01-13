<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    use ResponseTrait;

    public function index() {
        $data = [];
        $data['all'] = User::count();
        $data['admins'] = User::where('role', 'admin')->count();
        $data['users'] = User::where('role', 'user')->count();
        return $this->showResponse($data);
    }
}
