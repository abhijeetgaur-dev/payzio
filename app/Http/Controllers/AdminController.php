<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Vendor;
use App\Models\AdminDetail;
use App\Models\AdminBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admin $admin)
    {
        //
    }

    public function dashboard()
    {

        return view('admin.dashboard');
    }

    public function generateQr()
    {
        $vendors = Vendor::select('id', 'vendor_name', 'email', 'phone')->get();
        return view('admin.generateQR', compact('vendors'));
    }

    public function login()
    {
        return view('admin.login');
    }

    public function saveQr(Request $request , $id)
    {
        
        return redirect()->back()->with('success', 'QR code saved successfully.');
    }


    public function updateStatus(Request $request, $id ){
            $request->validate(['vendor_id' => 'required|exists:vendors,id',
                                'status' => 'boolean', ],
                            );
            $vendor = Vendor::findOrFail($id);
            $vendor->status = $request->input('status');
            $vendor->save();
            
            return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }



    public function settings()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.settings', compact('admin'));
    }

    public function updateSettings(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|min:10|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|different:current_password',
            'new_password_confirmation' => 'nullable|same:new_password',
        ]);

        // Update basic info
        $admin->name = $validated['name'];
        $admin->phone = $validated['phone'];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($admin->profile_image) {
                Storage::delete($admin->profile_image);
            }
            // Store new image
            $path = $request->file('profile_image')->store('admin-profiles', 'public');
            $admin->profile_image = $path;
        }

        // Update password if provided
        if ($validated['new_password']) {
            if (!Hash::check($validated['current_password'], $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $admin->password = Hash::make($validated['new_password']);
        }

        $admin->save();

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }

    public function showProfileDetails()
    {
        try {
            $admin = Auth::guard('admin')->user();

            // Load admin details
            $adminDetails = AdminDetail::where('admin_id', $admin->id)->first();

            // Load associated bank accounts
            $bankAccounts = AdminBankAccount::where('admin_id', $admin->id)->get();

            return view('admin.profile_details', [
                'admin' => $admin,
                'adminDetails' => $adminDetails,
                'bankAccounts' => $bankAccounts,
            ]);

        } catch (\Exception $e) {
            Log::error('Admin profile show error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load profile details.');
        }
    }

    public function editProfileDetails (){
        try {
            $admin = Auth::guard('admin')->user();

            // Load admin details
            $adminDetails = AdminDetail::where('admin_id', $admin->id)->first();

            // Load associated bank accounts
            $bankAccounts = AdminBankAccount::where('admin_id', $admin->id)->get();

            return view('admin.edit_profile_details', [
                'admin' => $admin,
                'adminDetails' => $adminDetails,
                'bankAccounts' => $bankAccounts,
            ]);

        } catch (\Exception $e) {
            Log::error('Admin profile show error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load profile details.');
        }
    }

    public function  updateProfileDetails(Request $request){

        $admin = auth('admin')->user();

        $validated = $request->validate([

        
        // Organization Details
        'contact_person' => 'nullable|string|max:255',
        'designation' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'pan_number' => 'nullable|string|max:20',
        'gst_number' => 'nullable|string|max:30',
        'admin_type' => 'nullable|string|max:100',
        'company_header' => 'nullable|string|max:500',
        'company_footer' => 'nullable|string|max:500',


        // Profile Image
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        
        // Documents
        'pan_card_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'gst_certificate_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'registration_doc_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        'cancelled_cheque_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        
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
        
        $admin = Auth::guard('admin')->user();
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
                'admin_type' => $validated['admin_type'] ?? null,
                'company_header' => $validated['company_header'] ?? null,
                'company_footer' => $validated['company_footer'] ?? null
            ]
        );
        
        // Handle document uploads
        $documentFields = [
            'company_logo',
            'pan_card_file',
            'gst_certificate_file',
            'registration_doc_file',
            'cancelled_cheque_file'
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
        
        return redirect()->route('admin.settings.details.show')
            ->with('success', 'Profile updated successfully!');
            
    } catch (ValidationException $e) {
        DB::rollBack();
        throw $e;
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Admin profile update error: ' . $e->getMessage());
        
        return back()->withInput()
            ->with('error', 'Failed to update profile. Please try again.');
    }
}

    ///////////////////////////////////////////////////////////////////////
    /////////////////This is for Transactions/////////////////////////////
    /////////////////(all of the routes below will be)///////////////////
    //////////////////(later given their own folders)/////////////////////////
    
    public function transaction(){
        return view('admin.transactions.allTransactions');
    }

    public function completedTransaction(){
        return view('admin.transactions.completed');
    }

    public function pendingTransaction(Request $request)
        {
        // Generate dummy vendors
        $vendors = [
            ['id' => 1, 'name' => 'Vendor A', 'email' => 'vendorA@example.com'],
            ['id' => 2, 'name' => 'Vendor B', 'email' => 'vendorB@example.com'],
            ['id' => 3, 'name' => 'Vendor C', 'email' => 'vendorC@example.com'],
        ];

        // Generate dummy transaction types
        $types = ['Purchase', 'Refund', 'Adjustment', 'Payment'];

        // Generate dummy pending transactions
        $transactions = [];
        
        for ($i = 1; $i <= 15; $i++) {
            $createdAt = now()->subDays(rand(0, 7));
            $vendor = $vendors[array_rand($vendors)];
            $amount = rand(100, 5000);
            
            $transactions[] = [
                'id' => $i,
                'reference' => 'TXN-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'vendor_id' => $vendor['id'],
                'vendor_name' => $vendor['name'],
                'type' => $types[array_rand($types)],
                'amount' => $amount,

                'created_at' => $createdAt->format('Y-m-d H:i:s'),
                'status' => 'Pending',
                'attachments' => rand(0, 3), // Random number of attachments
            ];
        }

        // Filter by vendor if provided
        if ($request->has('vendor') && !empty($request->vendor)) {
            $transactions = array_filter($transactions, function($txn) use ($request) {
                return $txn['vendor_id'] == $request->vendor;
            });
        }

        // Filter by type if provided
        if ($request->has('type') && !empty($request->type)) {
            $transactions = array_filter($transactions, function($txn) use ($request) {
                return $txn['type'] == $request->type;
            });
        }

        // Filter by amount range if provided
        if ($request->has('amount_min') && !empty($request->amount_min)) {
            $transactions = array_filter($transactions, function($txn) use ($request) {
                return $txn['amount'] >= $request->amount_min;
            });
        }

        if ($request->has('amount_max') && !empty($request->amount_max)) {
            $transactions = array_filter($transactions, function($txn) use ($request) {
                return $txn['amount'] <= $request->amount_max;
            });
        }

        return view('admin.transactions.pending', [
            'transactions' => $transactions,
            'vendors' => $vendors,
            'types' => $types,
            'totalAmount' => array_sum(array_column($transactions, 'amount')),
            'filters' => $request->all(),
        ]);
    }



    ///////////////////////////////////////////////////////////////////////////
    /////////////////This is for the reports section//////////////////////////
    //////////////////////////////////////////////////////////////////////////
      public function commissions(Request $request)
    {
        $vendors = Vendor::all()->toArray();

        // Generate dummy commission data
        $commissionRates= [2.5,5,7.5,10];
        $commissions= [];
        $statuses = ['pending', 'paid', 'cancelled'];
        
        foreach ($vendors as $vendor) {
            for ($i = 0; $i < 5; $i++) {
                $amount = rand(50, 500);
                $date = now()->subDays(rand(0, 90));
                $status = $statuses[array_rand($statuses)];
                $commissions[] = [
                    'id' => uniqid(),
                    'vendor_id' => $vendor['id'],
                    'vendor_name' => $vendor['vendor_name'],
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'amount' => $amount,
                    'commissionPercentage' => $commissionRates[rand(0,3)],
                    'status' => $status,
                    'created_at' => $date->format('Y-m-d H:i:s'),
                    'paid_at' => $status === 'paid' ? $date->addDays(rand(1, 5))->format('Y-m-d H:i:s') : null,
                ];
            }
        }

        // Filtering logic
        if ($request->has('vendor')) {
            $vendorId = $request->vendor;
            $commissions = array_filter($commissions, function($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $status = $request->status;
            $commissions = array_filter($commissions, function($item) use ($status) {
                return $item['status'] == $status;
            });
        }

        if ($request->has('date_from')) {
            $dateFrom = Carbon::parse($request->date_from);
            $commissions = array_filter($commissions, function($item) use ($dateFrom) {
                return Carbon::parse($item['created_at']) >= $dateFrom;
            });
        }

        if ($request->has('date_to')) {
            $dateTo = Carbon::parse($request->date_to);
            $commissions = array_filter($commissions, function($item) use ($dateTo) {
                return Carbon::parse($item['created_at']) <= $dateTo;
            });
        }

        // Calculate totals
        $totalCommission = array_sum(array_column($commissions, 'commission'));
        $totalAmount = array_sum(array_column($commissions, 'amount'));

        return view('admin.reports.commissions', [
            'commissions' => $commissions,
            'vendors' => $vendors,
            'totalCommission' => $totalCommission,
            'totalAmount' => $totalAmount,
            'filters' => $request->all(),
        ]);
    }

    public function vendorPayment(Request $request)
    {
        // Generate dummy vendors
        $vendors = [
            ['id' => 1, 'name' => 'Vendor A', 'account_number' => '****1234'],
            ['id' => 2, 'name' => 'Vendor B', 'account_number' => '****5678'],
            ['id' => 3, 'name' => 'Vendor C', 'account_number' => '****9012'],
            ['id' => 4, 'name' => 'Vendor D', 'account_number' => '****3456'],
        ];

        // Generate dummy payment methods
        $paymentMethods = ['Bank Transfer', 'Check', 'PayPal', 'Wire Transfer', 'Credit Card'];

        // Generate dummy payment statuses
        $statuses = ['Completed', 'Pending', 'Failed', 'Processing', 'Refunded'];

        // Generate dummy payment data
        $payments = [];
        
        for ($i = 1; $i <= 30; $i++) {
            $paymentDate = now()->subDays(rand(0, 90));
            $vendor = $vendors[array_rand($vendors)];
            $amount = rand(100, 5000);
            $fee = $amount * 0.02; // 2% fee
            $netAmount = $amount - $fee;
            
            $payments[] = [
                'id' => $i,
                'reference' => 'PAY-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'vendor_id' => $vendor['id'],
                'vendor_name' => $vendor['name'],
                'account_number' => $vendor['account_number'],
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'status' => $statuses[array_rand($statuses)],
                'payment_date' => $paymentDate->format('Y-m-d H:i:s'),
                'processed_by' => 'Admin ' . rand(1, 5),
                'notes' => ['Monthly payment', 'Service fee', 'Product purchase', 'Contract payment'][rand(0, 3)],
            ];
        }

        // Filter by date range if provided
        if ($request->has('from_date') && !empty($request->from_date)) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $payments = array_filter($payments, function($payment) use ($fromDate) {
                return Carbon::parse($payment['payment_date']) >= $fromDate;
            });
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $payments = array_filter($payments, function($payment) use ($toDate) {
                return Carbon::parse($payment['payment_date']) <= $toDate;
            });
        }

        // Filter by vendor if provided
        if ($request->has('vendor') && !empty($request->vendor)) {
            $payments = array_filter($payments, function($payment) use ($request) {
                return $payment['vendor_id'] == $request->vendor;
            });
        }

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $payments = array_filter($payments, function($payment) use ($request) {
                return $payment['status'] == $request->status;
            });
        }

        // Calculate totals
        $totalAmount = array_sum(array_column($payments, 'amount'));
        $totalFees = array_sum(array_column($payments, 'fee'));
        $totalNet = array_sum(array_column($payments, 'net_amount'));

        return view('admin.reports.vendorPayment', [
            'payments' => $payments,
            'vendors' => $vendors,
            'paymentMethods' => $paymentMethods,
            'statuses' => $statuses,
            'totalAmount' => $totalAmount,
            'totalFees' => $totalFees,
            'totalNet' => $totalNet,
            'filters' => $request->all(),
        ]);
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////// SETTLEMENTS SECTION ////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    public function pendingSettlements(Request $request)
    {
        // Generate dummy vendors
        $vendors = Vendor::all() -> toArray();
        // Generate dummy pending settlements
        $settlements = [];
        
        foreach ($vendors as $vendor) {
            $amount = rand(100, 5000);
            $date = now()->subDays(rand(1, 30));
            
            $settlements[] = [
                'id' => uniqid(),
                'vendor_id' => $vendor['id'],
                'vendor_name' => $vendor['vendor_name'],
                'account_number' => $vendor['account_number'],
                'amount' => $amount,
                'reference' => 'SET-' . strtoupper(uniqid()),
                'period_start' => $date->format('Y-m-d'),
                'period_end' => $date->addDays(rand(7, 30))->format('Y-m-d'),
                'transactions_count' => rand(3, 15),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'status' => 'pending',
            ];
        }

        // Filtering logic
        if ($request->has('vendor')) {
            $vendorId = $request->vendor;
            $settlements = array_filter($settlements, function($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('amount_min')) {
            $amountMin = $request->amount_min;
            $settlements = array_filter($settlements, function($item) use ($amountMin) {
                return $item['amount'] >= $amountMin;
            });
        }

        if ($request->has('amount_max')) {
            $amountMax = $request->amount_max;
            $settlements = array_filter($settlements, function($item) use ($amountMax) {
                return $item['amount'] <= $amountMax;
            });
        }

        return view('admin.settlements.pending', [
            'settlements' => $settlements,
            'vendors' => $vendors,
            'totalAmount' => array_sum(array_column($settlements, 'amount')),
            'filters' => $request->all(),
        ]);
    }


    public function completedSettlements(Request $request)
    {
        // Generate dummy vendors
        $vendors = Vendor::all() -> toArray();
        // Generate dummy pending settlements
        $settlements = [];
        
        foreach ($vendors as $vendor) {
            $amount = rand(100, 5000);
            $date = now()->subDays(rand(1, 30));
            
            $settlements[] = [
                'id' => uniqid(),
                'vendor_id' => $vendor['id'],
                'vendor_name' => $vendor['vendor_name'],
                'account_number' => $vendor['account_number'],
                'amount' => $amount,
                'reference' => 'SET-' . strtoupper(uniqid()),
                'period_start' => $date->format('Y-m-d'),
                'period_end' => $date->addDays(rand(7, 30))->format('Y-m-d'),
                'transactions_count' => rand(3, 15),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'status' => 'pending',
            ];
        }

        // Filtering logic
        if ($request->has('vendor')) {
            $vendorId = $request->vendor;
            $settlements = array_filter($settlements, function($item) use ($vendorId) {
                return $item['vendor_id'] == $vendorId;
            });
        }

        if ($request->has('amount_min')) {
            $amountMin = $request->amount_min;
            $settlements = array_filter($settlements, function($item) use ($amountMin) {
                return $item['amount'] >= $amountMin;
            });
        }

        if ($request->has('amount_max')) {
            $amountMax = $request->amount_max;
            $settlements = array_filter($settlements, function($item) use ($amountMax) {
                return $item['amount'] <= $amountMax;
            });
        }

        return view('admin.settlements.completed', [
            'settlements' => $settlements,
            'vendors' => $vendors,
            'totalAmount' => array_sum(array_column($settlements, 'amount')),
            'filters' => $request->all(),
        ]);
    }
//////////////////////////////////////////////////////////////
/////////////////Support Tickets//////////////////////////////
////////////////////////////////////////////////////////////
    public function ticketsRaised(Request $request)
    {
        // Generate dummy ticket categories
        $categories = [
            'Technical Issue',
            'Billing Inquiry',
            'Account Problem',
            'Feature Request',
            'General Inquiry'
        ];

        // Generate dummy ticket priorities
        $priorities = ['Low', 'Medium', 'High', 'Critical'];

        // Generate dummy ticket statuses
        $statuses = ['Open', 'In Progress', 'Pending Customer', 'Resolved'];

        // Generate dummy users (customers)
        $customers = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com'],
            ['id' => 4, 'name' => 'Alice Williams', 'email' => 'alice@example.com'],
        ];

        // Generate dummy tickets
        $tickets = [];
        
        for ($i = 1; $i <= 20; $i++) {
            $createdAt = now()->subDays(rand(0, 30));
            $customer = $customers[array_rand($customers)];
            
            $tickets[] = [
                'id' => $i,
                'reference' => 'TICKET-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'subject' => 'Ticket about ' . ['website issue', 'payment problem', 'login trouble', 'service question'][rand(0, 3)],
                'category' => $categories[array_rand($categories)],
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'customer_id' => $customer['id'],
                'customer_name' => $customer['name'],
                'customer_email' => $customer['email'],
                'created_at' => $createdAt->format('Y-m-d H:i:s'),
                'updated_at' => $createdAt->addHours(rand(1, 24))->format('Y-m-d H:i:s'),
                'last_response' => ['No response yet', 'Waiting for customer', 'Our team responded'][rand(0, 2)],
            ];
        }

        // Filter by date range if provided
        if ($request->has('from_date') && !empty($request->from_date)) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $tickets = array_filter($tickets, function($ticket) use ($fromDate) {
                return Carbon::parse($ticket['created_at']) >= $fromDate;
            });
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $tickets = array_filter($tickets, function($ticket) use ($toDate) {
                return Carbon::parse($ticket['created_at']) <= $toDate;
            });
        }

        // Sort by creation date (newest first)
        usort($tickets, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('admin.tickets.raised', [
            'tickets' => $tickets,
            'categories' => $categories,
            'priorities' => $priorities,
            'statuses' => $statuses,
            'filters' => $request->all(),
        ]);
    }

    public function ticketsClosed(Request $request)
{
    // Generate dummy ticket categories
    $categories = [
        'Technical Issue',
        'Billing Inquiry',
        'Account Problem',
        'Feature Request',
        'General Inquiry'
    ];

    // Generate dummy ticket priorities
    $priorities = ['Low', 'Medium', 'High', 'Critical'];

    // Generate dummy resolution types
    $resolutions = ['Solved', 'Not Reproducible', 'Duplicate', 'Won\'t Fix', 'Completed'];

    // Generate dummy users (customers)
    $customers = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
        ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com'],
        ['id' => 4, 'name' => 'Alice Williams', 'email' => 'alice@example.com'],
    ];

    // Generate dummy agents
    $agents = [
        ['id' => 101, 'name' => 'Support Agent 1'],
        ['id' => 102, 'name' => 'Support Agent 2'],
        ['id' => 103, 'name' => 'Support Agent 3'],
    ];

    // Generate dummy closed tickets
    $tickets = [];
    
    for ($i = 1; $i <= 20; $i++) {
        $createdAt = now()->subDays(rand(0, 60));
        $closedAt = $createdAt->copy()->addDays(rand(1, 7))->addHours(rand(1, 24));
        $customer = $customers[array_rand($customers)];
        $agent = $agents[array_rand($agents)];
        
        $tickets[] = [
            'id' => $i,
            'reference' => 'TICKET-' . str_pad($i, 6, '0', STR_PAD_LEFT),
            'subject' => 'Closed ticket about ' . ['website issue', 'payment problem', 'login trouble', 'service question'][rand(0, 3)],
            'category' => $categories[array_rand($categories)],
            'priority' => $priorities[array_rand($priorities)],
            'status' => 'Closed',
            'resolution' => $resolutions[array_rand($resolutions)],
            'customer_id' => $customer['id'],
            'customer_name' => $customer['name'],
            'customer_email' => $customer['email'],
            'agent_id' => $agent['id'],
            'agent_name' => $agent['name'],
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'closed_at' => $closedAt->format('Y-m-d H:i:s'),
            'time_to_resolve' => $createdAt->diffInHours($closedAt) . ' hours',
            'satisfaction_score' => rand(1, 5),
        ];
    }

    // Filter by date range if provided
    if ($request->has('from_date') && !empty($request->from_date)) {
        $fromDate = Carbon::parse($request->from_date)->startOfDay();
        $tickets = array_filter($tickets, function($ticket) use ($fromDate) {
            return Carbon::parse($ticket['closed_at']) >= $fromDate;
        });
    }

    if ($request->has('to_date') && !empty($request->to_date)) {
        $toDate = Carbon::parse($request->to_date)->endOfDay();
        $tickets = array_filter($tickets, function($ticket) use ($toDate) {
            return Carbon::parse($ticket['closed_at']) <= $toDate;
        });
    }

    // Filter by resolution if provided
    if ($request->has('resolution') && !empty($request->resolution)) {
        $tickets = array_filter($tickets, function($ticket) use ($request) {
            return $ticket['resolution'] == $request->resolution;
        });
    }

    // Sort by closed date (newest first)
    usort($tickets, function($a, $b) {
        return strtotime($b['closed_at']) - strtotime($a['closed_at']);
    });

    return view('admin.tickets.closed', [
        'tickets' => $tickets,
        'categories' => $categories,
        'priorities' => $priorities,
        'resolutions' => $resolutions,
        'filters' => $request->all(),
    ]);
}



}
