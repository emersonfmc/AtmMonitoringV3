<?php

namespace App\Http\Controllers\ATM;
use Illuminate\Http\Request;
use App\Models\ClientInformation;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DataBankLists;
use App\Models\DataCollectionDate;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ClientContoller extends Controller
{
    public function client_page()
    {
        $userGroup = Auth::user()->UserGroup->group_name;  // Assuming the group name is stored in the 'name' field

        if (in_array($userGroup, ['Developer','Admin','Everfirst Admin'])) {
            $branches = Branch::where('status', 'Active')->get();
        } else {
            $branches = collect();  // Return an empty collection if not authorized
        }

        $DataCollectionDates = DataCollectionDate::where('status', 'Active')->get();
        $DataBankLists = DataBankLists::where('status', 'Active')->get();

        return view('pages.pages_backend.atm.atm_clients_page', compact('branches','userGroup','DataCollectionDates','DataBankLists'));
    }

    public function client_data()
    {
        $userBranchId = Auth::user()->branch_id;

        $query = ClientInformation::with('Branch', 'AtmClientBanks')
                    ->latest('updated_at');

        if (!empty($userBranchId) && $userBranchId != 0 ||  $userBranchId == NULL) {
            $query->where('branch_id', $userBranchId);
        }

        $branchData = $query->get();

        return DataTables::of($branchData)
            ->setRowId('id')
            ->make(true);
    }


public function PensionNumberValidate(Request $request)
{
    // Remove any non-numeric characters (like hyphens) from the pension number
    $pension_number_get = preg_replace('/[^0-9]/', '', $request->pension_number);

    // Get the authenticated user's branch_id
    $user_branch_id =  Auth::user()->branch_id;

    // Query to find if the pension number exists in the client information
    $clientInfo = ClientInformation::with('Branch', 'DataPensionTypesLists')
                    ->where('pension_number', $pension_number_get)
                    ->first();

    if ($clientInfo) {
        // If the user has no branch_id (user is not assigned to any specific branch)
        if (is_null($user_branch_id)) {
            return response()->json(['error' => 'Pension number already exists.']);
        }

        // Check if the found pension number belongs to the same branch as the user
        if ($clientInfo->branch_id == $user_branch_id) {
            return response()->json(['error' => 'Pension number already exists in the same branch.']);
        } else {
            // Pension number exists but in a different branch
            return response()->json(['error' => 'Pension number already exists in another branch.']);
        }
    }

    // If the pension number does not exist, allow further processing
    return response()->json(['success' => 'Pension number is valid.'], 200);
}



}
