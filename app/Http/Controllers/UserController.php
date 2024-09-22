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
        if($request->user_type === 'Head_Office')
        {
            dd('headoffice');
        }
        else if($request->user_type === 'District')
        {
            dd('District');
        }
        else if($request->user_type === 'Area')
        {
            dd('Area');
        }
        else if($request->user_type === 'Branch')
        {
            dd('Branch');
        }
        else{

        }




        // return response()->json($user);
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
