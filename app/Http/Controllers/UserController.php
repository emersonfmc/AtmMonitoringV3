<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TblDistrict;
use App\Models\TblUserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function users_page()
    {
        $user_groups = TblUserGroup::whereNull('deleted_at')
            ->where('status','Active')
            ->get();

        return view('pages.pages_backend.settings.users_page',compact('user_groups'));
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

    public function users_create(Request $request)
    {
        // Check if the password and confirm password match
        if ($request->password !== $request->confirm_password) {
            return response()->json(['error' => 'Passwords do not match!'], 400); // 400 Bad Request
        }
        else
        {
            // Check if the email already exists
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['error' => 'Email already exists!'], 409); // 409 Conflict
            }

            // Check if the employee number already exists
            if (User::where('employee_id', $request->employee_id)->exists()) {
                return response()->json(['error' => 'Employee number already exists!'], 409); // 409 Conflict
            }


            if($request->user_type === 'Head_Office')
            {
                $user_group_id = $request->user_group_id;
                $district_id = NULL;
                $branch_id = NULL;
                $area_id = NULL;
            }
            else if($request->user_type === 'District')
            {
                $user_group_id = NULL;
                $district_id = $request->district_id;
                $branch_id = NULL;
                $area_id = NULL;
            }
            else if($request->user_type === 'Area')
            {
                $district_id = $request->district_manager_area_id;
                $area_id = $request->area_supervisor_id;
            }
            else if($request->user_type === 'Branch')
            {
                $user_group_id = $request->user_group_branch_id;
                $branch_id = $request->branch_id;
                $district_id = $request->district_manager_id;
                $area_id = $request->area_id;
            }
            else if($request->user_type === 'Admin')
            {
                $user_group_id = $request->user_group_id;
                $branch_id = NULL;
                $district_id = NULL;
                $area_id = NULL;
            }
            else if($request->user_type === 'Developer')
            {
                $user_group_id = $request->user_group_id;
                $branch_id = NULL;
                $district_id = NULL;
                $area_id = NULL;
            }
            else
            {
            }

                    // Create the user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                // 'contact_no' => $request->contact_no,
                // 'address' => $request->address,
                'name' => $request->username,
                'password' => Hash::make($request->password), // Hash the password
                'email_verified_at' => Carbon::now(),
                'session' => 'Offline',
                'user_types' => $request->user_types,
                'user_group_id' => $user_group_id,
                'branch_id' => $branch_id,
                'district_code_id' => $district_id,
                'area_code_id' => $area_id,
                'status' => 'Active',
                'company_id' => 2,
                'dob' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }



        //     return response()->json(['success' => 'User created successfully!']);

        // }
    }


    public function users_update($id)
    {
        $update_user = User::findOrFail($id)->whereNull('deleted_at')->get();
        return response()->json($update_user);

        $update_user->update([
            'quantity' => $request->quantity_received,
            'status' => 'Completed',
            'received_by_id' => Auth::user()->id,
            'loss_quantity' =>  $request->loss_quantity,
            'damage_quantity' =>  $request->damage_quantity,
        ]);
    }



}
