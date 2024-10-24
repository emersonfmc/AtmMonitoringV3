<?php

namespace App\Http\Controllers\ATM;
use App\Models\Branch;
use App\Models\SystemLogs;

use Illuminate\Http\Request;
use App\Models\DataBankLists;
use App\Models\DataUserGroup;
use App\Models\AtmClientBanks;
use Illuminate\Support\Carbon;
use App\Models\ClientInformation;
use App\Models\DataCollectionDate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AtmClientBanksTransaction;
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

        // Start the query with the necessary relationships
        $query = ClientInformation::with('Branch', 'AtmClientBanks')->latest('updated_at');

        // Check if the user has a valid branch_id
        if ($userBranchId !== null && $userBranchId !== 0) {
            // Filter by branch_id if it's set and valid
            $query->where('branch_id', $userBranchId);
        }

        // Get the filtered data
        $branchData = $query->get();

        // Return the data as DataTables response
        return DataTables::of($branchData)
            ->setRowId('id')
            ->make(true);
    }

    public function clientCreate(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $existingPensionNumber = ClientInformation::where('pension_number', $request->pension_number)
                        ->where('pension_type', $request->pension_type)
                        ->exists();

            // If it exists, return a response with a message
            if ($existingPensionNumber) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Duplicate Pension Number Found'
                ]);
            }
            else
            {
                // Validate First Existing Bank Account No Start
                    if (is_array($request->atm_number)) {
                        // Clear hyphens from each element in the array
                        $atmNumbers = array_map(function($number) {
                            return str_replace('-', '', $number); // Remove hyphens
                        }, $request->atm_number);

                        // Use Eloquent to check for existing bank_account_no
                        $existingAccounts = AtmClientBanks::whereIn('bank_account_no', $atmNumbers)
                            ->whereNotNull('bank_account_no')
                            ->get(['bank_account_no']); // Get only the bank_account_no field
                    } else {
                        // Clear hyphen from the single atm_number
                        $atmNumber = str_replace('-', '', $request->atm_number);

                        $existingAccounts = AtmClientBanks::where('bank_account_no', $atmNumber)
                            ->whereNotNull('bank_account_no')
                            ->get(['bank_account_no']); // Get only the bank_account_no field
                    }

                    // Check if any existing accounts were found
                    if ($existingAccounts->isNotEmpty())
                    {
                        // Extract existing bank_account_no values for display
                        $existingNumbers = $existingAccounts->pluck('bank_account_no')->toArray();
                        $existingNumbersString = implode(', ', $existingNumbers); // Convert to string

                        // Prepare the message to include existing numbers
                        $message = "Duplicate ATM / Passbook / Sim Number $existingNumbersString,";
                        return response()->json([
                            'status' => 'error',
                            'message' => $message
                        ]);
                    }
                // Validate First Existing Bank Account No End

                if ($request->branch_id !== null) {
                    $branch_id = $request->branch_id; // Use the branch_id from the request if it's not null
                } else {
                    $branch_id = Auth::user()->branch_id; // Fall back to the authenticated user's branch_id
                }

                // Get the branch abbreviation
                $BranchGet = Branch::where('id', $branch_id)->first();
                $branch_abbreviation = $BranchGet->branch_abbreviation;

                // Fetch the last transaction number based on the branch_id and branch_code
                $lastTransaction = AtmClientBanksTransaction::where('branch_id', $branch_id)
                    ->where('branch_code', session('branch_id')) // Use session helper to get the session value
                    ->orderBy('transaction_number', 'desc') // Order by transaction_number in descending order
                    ->first();

                if ($lastTransaction) {
                    $lastPart = substr($lastTransaction->transaction_number, strrpos($lastTransaction->transaction_number, '-') + 1);
                    $lastadded = (int)$lastPart;
                } else {
                    $lastadded = 0;
                }

                // Create the new transaction number
                $newTransactionNumber = $branch_abbreviation . '-' . date('Y') . '-' . str_pad(($lastadded + 1), 5, '0', STR_PAD_LEFT);

                // Dump the new transaction number
                dd($newTransactionNumber);



            }




            // DataUserGroup::create([
            //     'group_name' => $request->user_group,
            //     'company_id' => 2,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]);

            // // Create a system logs
            // SystemLogs::create([
            //     'system' => 'ATM Monitoring',
            //     'action' => 'Create',
            //     'description' => 'Create New Usergroup' . $request->user_group,
            //     'user_id' => Auth::user()->id,
            //     'ip_address' => $request->ip(),
            //     'created_at' => Carbon::now(),
            //     'company_id' => Auth::user()->company_id,
            // ]);

            DB::commit();  // Commit the transaction if successful
        }
        catch (\Exception $e)
        {
            DB::rollBack();  // Roll back the transaction on error
            return response()->json([
                'status' => 'error',
                'message' => 'An Error Occurred, Please Check and Repeat!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User group Created successfully!'  // Changed message to reflect update action
        ]);
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
