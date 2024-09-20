<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TblDistrict;
use App\Models\TblUserGroup;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function users_page()
    {
        return view('pages.pages_backend.settings.users_page');
    }

    public function users_data()
    {
       $users = User::latest('updated_at')
            ->get();

        return DataTables::of($users)
        ->addColumn('password', function($user) {
            // Return the hashed password for display (Not recommended for security reasons)
            return $user->password;
        })
        ->setRowId('id')
        ->make(true);
    }



}
