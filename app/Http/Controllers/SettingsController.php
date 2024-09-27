<?php

namespace App\Http\Controllers;

use App\Models\TblDistrict;
use App\Models\TblUserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AtmBankLists;
use App\Models\AtmPensionTypesLists;
use App\Models\TblArea;
use App\Models\TblBranch;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    public function users_group_page()
    {
        return view('pages.pages_backend.settings.users_group_page');
    }

    public function users_group_data()
    {
       $user_group = TblUserGroup::with('Company')
            ->latest('updated_at')
            ->get();

        return DataTables::of($user_group)
        ->addColumn('password', function($user) {
            // Return the hashed password for display (Not recommended for security reasons)
            return $user->password;
        })
        ->setRowId('id')
        ->make(true);
    }

    public function districts_page()
    {
        return view('pages.pages_backend.settings.district_page');
    }

    public function districts_data()
    {
       $district = TblDistrict::with('Company')
            ->latest('updated_at')
            ->get();

        return DataTables::of($district)
        ->setRowId('id')
        ->make(true);
    }

    public function area_page()
    {
        return view('pages.pages_backend.settings.area_page');
    }

    public function area_data()
    {
       $district = TblArea::with('Company','District')
            ->latest('updated_at')
            ->get();

        return DataTables::of($district)
        ->setRowId('id')
        ->make(true);
    }

    public function branch_page()
    {
        return view('pages.pages_backend.settings.branch_page');
    }

    public function branch_data()
    {
       $branch = TblBranch::with('Company','District','Area')
            ->latest('updated_at')
            ->get();

        return DataTables::of($branch)
        ->setRowId('id')
        ->make(true);
    }

    public function bank_page()
    {
        return view('pages.pages_backend.settings.bank_lists_page');
    }

    public function bank_data()
    {
       $branch = AtmBankLists::latest('updated_at')
            ->get();

        return DataTables::of($branch)
        ->setRowId('id')
        ->make(true);
    }

    public function pension_types_page()
    {
        return view('pages.pages_backend.settings.pension_types_page');
    }

    public function pension_types_data()
    {
       $branch = AtmPensionTypesLists::latest('updated_at')
            ->get();

        return DataTables::of($branch)
        ->setRowId('id')
        ->make(true);
    }

    public function login_page()
    {
        return view('auth.login_page');
    }












}
