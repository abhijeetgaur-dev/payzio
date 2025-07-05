<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\VendorBankAccount;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function edit()
    {
        try {
            $vendor = Auth::guard('vendor')->user();

            // Load associated bank accounts
            $bankAccounts = VendorBankAccount::where('vendor_id', $vendor->id)->get();

            return view('vendor.settings.edit', [
                'vendor' => $vendor,
                'bankAccounts' => $bankAccounts ?? [],
            ]);
        } catch (\Exception $e) {
            Log::error('Vendor profile show error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load profile details.');
        }
    }

public function update(Request $request)
{
    $vendor = Auth::guard('vendor')->user();

    $validated = $request->validate([
        // Organization Details

        'phone' => 'required|string|max:255',
        'alternate_phones' => 'nullable|string|max:255',
        'alternate_emails' => 'nullable|string|max:255',
        'contact_person' => 'nullable|string|max:255',
        'designation' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'other_certificates' => 'nullable|string|max:30',
        'company_header' => 'nullable|string|max:500',
        'company_footer' => 'nullable|string|max:200',
        'alternate_phones_person' => 'nullable|string|max:200',
        'alternate_contact' => 'nullable|string|max:200',

        // Profile Image & Documents
        'company_logo' => ($vendor && $vendor->company_logo)
            ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'pan_card_file' => ($vendor && $vendor->pan_card_file)
            ? 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120'
            : 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'gst_certificate_file' => ($vendor && $vendor->gst_certificate_file)
            ? 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120'
            : 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'registration_doc_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'other_docs' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',

        // Bank Accounts
        'bank_accounts' => 'nullable|array',
        'bank_accounts.*.id' => 'sometimes|exists:vendor_bank_accounts,id,vendor_id,' . $vendor->id,
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

        // Update vendor details directly
        $vendor->update([
            'contact_person' => $validated['contact_person'] ?? null,
            'alternate_phones' => $validated['alternate_phones'] ?? null,
            'alternate_emails' => $validated['alternate_emails'] ?? null,
            'contact_person' => $validated['contact_person'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'website' => $validated['website'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'other_certificates' => $validated['other_certificates'] ?? null,
            'company_header' => $validated['company_header'] ?? null,
            'company_footer' => $validated['company_footer'] ?? null,
            'alternate_contact_person' => $validated['alternate_contact_person'] ?? null,
        ]);

        // Handle document uploads
        $documentFields = [
            'company_logo',
            'pan_card_file',
            'gst_certificate_file',
            'registration_doc_file',
            'other_docs'];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                if ($vendor->$field) {
                    Storage::delete('public/' . $vendor->$field);
                }

                $path = $request->file($field)->store('documents/vendor', 'public');
                $vendor->$field = $path;
            }
        }

        $vendor->save(); // Save changes including document paths

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
                    // Update existing
                    $account = VendorBankAccount::where('id', $bankData['id'])
                        ->where('vendor_id', $vendor->id)
                        ->firstOrFail();
                    $account->update($accountData);
                    $existingAccountIds[] = $account->id;
                } else {
                    // Create new
                    $account = new VendorBankAccount($accountData);
                    $account->vendor_id = $vendor->id;
                    $account->save();
                    $existingAccountIds[] = $account->id;
                }
            }

            // Delete removed bank accounts
            VendorBankAccount::where('vendor_id', $vendor->id)
                ->whereNotIn('id', $existingAccountIds)
                ->delete();
        }

        DB::commit();

        return redirect()->route('vendor.settings.edit')->with('success', 'Profile updated successfully!');
    } catch (ValidationException $e) {
        DB::rollBack();
        throw $e;
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Vendor profile update error: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Failed to update profile. Please try again.');
    }
}


    public function changePassword()
    {
        return view('vendor.settings.change_password');
    }

    public function changePasswordUpdate(Request $request)
    {
        $vendor = auth()->guard('vendor')->user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $vendor->password)) {
            return redirect()
                ->back()
                ->withErrors([
                    'current_password' => 'The current password is incorrect.',
                ])
                ->withInput();
        }

        // Update password
        $vendor->password = Hash::make($validated['new_password']);
        $vendor->save();

        return redirect()->route('vendor.settings.edit')->with('success', 'Password updated successfully!');
    }
}
