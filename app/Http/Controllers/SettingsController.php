<?php

namespace App\Http\Controllers;

use App\Models\DataArea;
use App\Models\DataDistrict;
use App\Models\DataBankLists;
use App\Models\DataUserGroup;
use App\Models\DataPensionTypesLists;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    public function users_group_page()
    {
        return view('pages.pages_backend.settings.users_group_page');
    }

    public function users_group_data()
    {
       $user_group = DataUserGroup::with('Company')
            ->latest('updated_at')
            ->get();

        return DataTables::of($user_group)
        ->setRowId('id')
        ->make(true);
    }

    public function users_group_get($id)
    {
        $TblUserGroup = DataUserGroup::with('Company')->findOrFail($id);
        return response()->json($TblUserGroup);
    }

    public function users_group_create(Request $request)
    {
        // DB::beginTransaction();
        // try
        // {
            // Proceed with inserting if validation passes
            DataUserGroup::create([
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
            $TblUserGroup = DataUserGroup::findOrFail($request->item_id);

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
       $district = DataDistrict::with('Company')
            ->latest('updated_at')
            ->get();

        return DataTables::of($district)
        ->setRowId('id')
        ->make(true);
    }

    public function districtsGet($id)
    {
        $TblDistrict = DataDistrict::with('Company')->findOrFail($id);
        return response()->json($TblDistrict);
    }

    public function districtsCreate(Request $request)
    {

        // Proceed with inserting if validation passes
        DataDistrict::create([
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
        $TblDistrict = DataDistrict::findOrFail($request->item_id);

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
        $districts = DataDistrict::latest('updated_at')->get();

        return view('pages.pages_backend.settings.area_page', compact('districts'));
    }

    public function area_data()
    {
       $district = DataArea::with('Company','District')
            ->latest('updated_at')
            ->get();

        return DataTables::of($district)
        ->setRowId('id')
        ->make(true);
    }

    public function areaGet($id)
    {
        $TblArea = DataArea::findOrFail($id);
        return response()->json($TblArea);
    }

    public function areaCreate(Request $request)
    {

        // Proceed with inserting if validation passes
        DataArea::create([
            'area_no' => $request->area_no,
            'area_supervisor' => $request->area_supervisor,
            'district_id' => $request->district_id,
            'status' => 'Active',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Area created successfully!'
        ]);
    }

    public function areaUpdate(Request $request)
    {
        // Find the user group by ID
        $TblArea = DataArea::findOrFail($request->item_id);
        $TblArea->update([  // Update the instance instead of using the class method
            'area_no' => $request->area_no,
            'area_supervisor' => $request->area_supervisor,
            'district_id' => $request->district_id,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Area updated successfully!'  // Changed message to reflect update action
        ]);
    }

    public function branch_page()
    {
        $TblDistrict = DataDistrict::latest('updated_at')
            ->get();

        return view('pages.pages_backend.settings.branch_page', compact('TblDistrict'));
    }

    public function branch_data()
    {
       $branch = Branch::with('Company','District','Area')
            ->latest('updated_at')
            ->get();

        return DataTables::of($branch)
        ->setRowId('id')
        ->make(true);
    }

    public function areaGetBydistrict(Request $request)
    {
        // $district_id = $request->district_id;
        $TblArea = DataArea::where('district_id', $request->district_id)->get(); // get() instead of first()
        return response()->json($TblArea);
    }

    public function branchCreate(Request $request)
    {
        // Extract the first two letters of branch_location and convert to uppercase
        $branchAbbreviation = strtoupper(substr($request->branch_location, 0, 2));

        // Proceed with inserting if validation passes
        Branch::create([
            'district_id' => $request->district_id,
            'area_id' => $request->area_id,
            'branch_location' => $request->branch_location,
            'branch_head' => $request->branch_head,
            'branch_abbreviation' => $branchAbbreviation,
            'company_id' => 2,
            'status' => 'Active',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Branch created successfully!'
        ]);
    }

    public function branchUpdate(Request $request)
    {
        // Find the user group by ID
        $AtmBankLists = Branch::findOrFail($request->item_id);

        // Proceed with update if validation passes
        $AtmBankLists->update([  // Update the instance instead of using the class method
            'district_id' => $request->district_id,
            'area_id' => $request->area_id,
            'branch_location' => $request->branch_location,
            'branch_head' => $request->branch_head,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Branch updated successfully!'  // Changed message to reflect update action
        ]);
    }

    public function bank_page()
    {
        return view('pages.pages_backend.settings.bank_lists_page');
    }

    public function bank_data()
    {
       $branch = DataBankLists::latest('updated_at')
            ->get();

        return DataTables::of($branch)
        ->setRowId('id')
        ->make(true);
    }

    public function bankGet($id)
    {
        $AtmBankLists = DataBankLists::findOrFail($id);
        return response()->json($AtmBankLists);
    }

    public function bankCreate(Request $request)
    {

        // Proceed with inserting if validation passes
        DataBankLists::create([
            'bank_name' => $request->bank_name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Bank created successfully!'
        ]);
    }

    public function bankUpdate(Request $request)
    {
        // Find the user group by ID
        $AtmBankLists = DataBankLists::findOrFail($request->item_id);

        // Proceed with update if validation passes
        $AtmBankLists->update([  // Update the instance instead of using the class method
            'bank_name' => $request->bank_name,
            'updated_at' => Carbon::now(),  // Updated timestamp
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'District updated successfully!'  // Changed message to reflect update action
        ]);
    }

    public function pension_types_page()
    {
        return view('pages.pages_backend.settings.pension_types_page');
    }

    public function pension_types_data()
    {
       $branch = DataPensionTypesLists::latest('updated_at')
            ->get();

        return DataTables::of($branch)
        ->setRowId('id')
        ->make(true);
    }

    public function pension_typesGet($id)
    {
        $AtmPensionTypesLists = DataPensionTypesLists::findOrFail($id);
        return response()->json($AtmPensionTypesLists);
    }

    public function pension_typesCreate(Request $request)
    {
        DataPensionTypesLists::create([
            'pension_name' => $request->pension_name,
            'types' => $request->types,
            'status' => 'Active',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pension Types Created successfully!'
        ]);
    }

    public function pension_typesUpdate(Request $request)
    {
        // Find the user group by ID
        $AtmPensionTypesLists = DataPensionTypesLists::findOrFail($request->item_id);

        // Proceed with update if validation passes
        $AtmPensionTypesLists->update([  // Update the instance instead of using the class method
            'pension_name' => $request->pension_name,
            'types' => $request->types,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pension Types updated successfully!'  // Changed message to reflect update action
        ]);
    }


    public function login_page()
    {
        return view('auth.login_page');
    }












}
