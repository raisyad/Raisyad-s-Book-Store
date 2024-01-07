<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ViewAccountController extends Controller
{
    public function index() {
        $dataUser = DB::table('users')
                    ->join('role', 'users.role_id', '=', 'role.id')
                    ->select('users.*', 'role.type_role')
                    ->paginate(2);
        return view('pages.ViewAccount', ['dataUser' => $dataUser, 'titles' => 'View Account']);
    }
}
