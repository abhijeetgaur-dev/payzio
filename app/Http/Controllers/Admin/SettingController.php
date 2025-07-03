<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\AdminDetail;
use App\Models\AdminBankAccount;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $admin = Auth::guard('admin')->user();

            // Load admin details
            $adminDetails = AdminDetail::where('admin_id', $admin->id)->first();

            // Load associated bank accounts
            $bankAccounts = AdminBankAccount::where('admin_id', $admin->id)->get();

            return view('admin.settings.index', [
                'admin' => $admin,
                'adminDetails' => $adminDetails,
                'bankAccounts' => $bankAccounts,
            ]);

        } catch (\Exception $e) {
            Log::error('Admin profile show error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load profile details.');
        }
    }

    public function edit (){
        try {
            $admin = Auth::guard('admin')->user();

            // Load admin details
            $adminDetails = AdminDetail::where('admin_id', $admin->id)->first();

            // Load associated bank accounts
            $bankAccounts = AdminBankAccount::where('admin_id', $admin->id)->get();

            return view('admin.settings.edit', [
                'admin' => $admin,
                'adminDetails' => $adminDetails ?? [],
                'bankAccounts' => $bankAccounts ?? [],
            ]);

        } catch (\Exception $e) {
            Log::error('Admin profile show error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load profile details.');
        }
    }

    public function  update(Request $request){

        $admin = auth('admin')->user();

        $validated = $request->validate([

        'company_name' => 'required|string|max:255',
        // Organization Details
        'contact_person' => 'nullable|string|max:255',
        'designation' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'pan_number' => 'required|string|max:20',
        'gst_number' => 'required|string|max:30',
        'other_certificates' => 'nullable|string|max:30',
        'admin_type' => 'nullable|string|max:100',
        'company_header' => 'nullable|string|max:500',
        'company_footer' => 'nullable|string|max:200',
        'alternate_phones' => 'nullable|string|max:200',
        'phone' => 'required|string|max:200',
        'alternate_emails' => 'nullable|string|max:200',
        'alternate_contact_person' => 'nullable|string|max:200',


        // Profile Image
        'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        
        // Documents
        'pan_card_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'gst_certificate_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'registration_doc_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'other_docs' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        
        // Bank Accounts
        'bank_accounts' => 'nullable|array',
        'bank_accounts.*.id' => 'sometimes|exists:admin_bank_accounts,id,admin_id,'.Auth::guard('admin')->id(),
        'bank_accounts.*.bank_name' => 'required_with:bank_accounts|string|max:100',
        'bank_accounts.*.account_number' => 'required_with:bank_accounts|string|max:30',
        'bank_accounts.*.account_holder' => 'required_with:bank_accounts|string|max:100',
        'bank_accounts.*.ifsc_code' => 'required_with:bank_accounts|string|max:20',
        'bank_accounts.*.branch_name' => 'nullable|string|max:100',
        'bank_accounts.*.is_primary' => 'sometimes|boolean',
        'bank_accounts.*.notes' => 'nullable|string|max:500',
    ]);

      try {
        DB::beginTransaction();
        $admin->name = $validated['company_name'];
        $admin->phone = $validated['phone'];
        $admin->save();


        // $adminDetails = AdminDetail::where('admin_id', $admin->id)->first();
        // if($adminDetails && $adminDetails->admin_type){
        //     throw new \Exception('Admin type cannot be changed once set.');
        // }
        // Update or create admin details
        $adminDetails = AdminDetail::updateOrCreate(
            ['admin_id' => $admin->id],
            [
                'contact_person' => $validated['contact_person'] ?? null,
                'designation' => $validated['designation'] ?? null,
                'website' => $validated['website'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
                'pan_number' => $validated['pan_number'] ?? null,
                'gst_number' => $validated['gst_number'] ?? null,
                'other_certificates' => $validated['other_certificates'] ?? null,
                'admin_type' => $validated['admin_type'] ?? null,
                'company_header' => $validated['company_header'] ?? null,
                'company_footer' => $validated['company_footer'] ?? null,
                'alternate_phones' => $validated['alternate_phones'] ?? null,
                'alternate_emails' => $validated['alternate_emails'] ?? null,
                'alternate_contact_person' => $validated['alternate_contact_person'] ?? null,
            ]
        );

        // Handle document uploads
        $documentFields = [
            'company_logo',
            'pan_card_file',
            'gst_certificate_file',
            'registration_doc_file',
            'other_docs'
        ];
        
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($adminDetails->$field) {
                    Storage::delete('public/' . $adminDetails->$field);
                }
                
                $path = $request->file($field)->store('documents/admin', 'public');
                $adminDetails->$field = $path;
            }
        }
        
        $adminDetails->save();
        
        // Handle bank accounts
        if (!empty($validated['bank_accounts'])) {
            $existingAccountIds = [];
            
            foreach ($validated['bank_accounts'] as $bankData) {
                $accountData = [
                    'bank_name' => $bankData['bank_name'],
                    'account_number' => $bankData['account_number'],
                    'account_holder' => $bankData['account_holder'],
                    'ifsc_code' => $bankData['ifsc_code'],
                    'branch_name' => $bankData['branch_name'] ?? null,
                    'is_primary' => $bankData['is_primary'] ?? false,
                    'notes' => $bankData['notes'] ?? null,
                ];
                
                if (!empty($bankData['id'])) {
                    // Update existing account
                    $account = AdminBankAccount::where('id', $bankData['id'])
                        ->where('admin_id', $admin->id)
                        ->firstOrFail();
                    
                    $account->update($accountData);
                    $existingAccountIds[] = $account->id;
                } else {
                    // Create new account
                    $account = new AdminBankAccount($accountData);
                    $account->admin_id = $admin->id;
                    $account->save();
                    $existingAccountIds[] = $account->id;
                }
            }
            
            // Delete accounts not included in the request
            AdminBankAccount::where('admin_id', $admin->id)
                ->whereNotIn('id', $existingAccountIds)
                ->delete();
        }
        
        DB::commit();
        
        return redirect()->route('admin.settings.edit')
            ->with('success', 'Profile updated successfully!');
            
    } catch (ValidationException $e) {
        DB::rollBack();
        throw $e;
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Admin profile update error: ' . $e->getMessage());
        
        return back()->withInput()
            ->with('error', 'Failed to update profile. Please try again.   ',  $e);
    }
}

    public function changePassword()
    {
        return view('admin.settings.change_password');
    }

public function changePasswordUpdate(Request $request)
{
    $admin = auth()->guard('admin')->user();

    $validated = $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|different:current_password|confirmed',
        'new_password_confirmation' => 'required',
    ]);

    // Verify current password
    if (!Hash::check($validated['current_password'], $admin->password)) {
        return redirect()->back()->withErrors([
            'current_password' => 'The current password is incorrect.'
        ])->withInput();
    }

    // Update password
    $admin->password = Hash::make($validated['new_password']);
    $admin->save();

    return redirect()->route('admin.settings.edit')->with('success', 'Password updated successfully!');
}


    
}
