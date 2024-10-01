<?php

namespace App\Http\Controllers;

use App\Models\TblArea;
use App\Models\TblBranch;
use App\Models\TblDistrict;
use App\Models\AtmBankLists;
use App\Models\TblUserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AtmPensionTypesLists;
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
        ->setRowId('id')
        ->make(true);
    }

    public function users_group_get($id)
    {
        $TblUserGroup = TblUserGroup::with('Company')->findOrFail($id);
        return response()->json($TblUserGroup);
    }

    public function users_group_create(Request $request)
    {
        // DB::beginTransaction();
        // try
        // {
            // Proceed with inserting if validation passes
            TblUserGroup::create([
                'group_name' => $request->user_group,
                'company_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        // }
        // catch (\Exception $e)
        // {
        //     DB::rollBack();
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'An Error Occurs, Please Check and Repeat!'
        //     ]);
        //     throw $e;
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'User group created successfully!'
        ]);
    }

    public function users_group_update(Request $request)
    {
        DB::beginTransaction();
        try {
            // Find the user group by ID
            $TblUserGroup = TblUserGroup::findOrFail($request->item_id);

            // Proceed with update if validation passes
            $TblUserGroup->update([  // Update the instance instead of using the class method
                'group_name' => $request->user_group,
                'updated_at' => Carbon::now(),  // Updated timestamp
            ]);

            DB::commit();  // Commit the transaction if successful
        } catch (\Exception $e) {
            DB::rollBack();  // Roll back the transaction on error
            return response()->json([
                'status' => 'error',
                'message' => 'An Error Occurred, Please Check and Repeat!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User group updated successfully!'  // Changed message to reflect update action
        ]);
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

    public function districtsGet($id)
    {
        $TblDistrict = TblDistrict::with('Company')->findOrFail($id);
        return response()->json($TblDistrict);
    }

    public function districtsCreate(Request $request)
    {

        // Proceed with inserting if validation passes
        TblDistrict::create([
            'district_name' => $request->district_name,
            'district_number' => $request->district_number,
            'email' => $request->email,
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'District created successfully!'
        ]);
    }

    public function districtsUpdate(Request $request)
    {
        // Find the user group by ID
        $TblDistrict = TblDistrict::findOrFail($request->item_id);

        // Proceed with update if validation passes
        $TblDistrict->update([  // Update the instance instead of using the class method
            'district_name' => $request->district_name,
            'district_number' => $request->district_number,
            'email' => $request->email,
            'updated_at' => Carbon::now(),  // Updated timestamp
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'District updated successfully!'  // Changed message to reflect update action
        ]);
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
