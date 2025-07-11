<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    public function allTransactions(Request $request)
    {
        $allVendors = Vendor::all();
        $showStats = 1;
        $link = 'admin.transactions.all';

        // Allowed sort fields
        $allowedSorts = ['id', 'amount', 'created_at', 'vendor_name', 'commission_total', 'status'];
        $sortBy = in_array($request->sort, $allowedSorts) ? $request->sort : 'created_at';
        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        // Base query
        $query = Transaction::with('vendor');

        // Filters
        if ($request->has('vendor_id') && $request->vendor_id != '') {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting logic
        if ($sortBy === 'vendor_name') {
            // Fetch all then sort manually by vendor name
            $transactions = $query->get()->sortBy(
                function ($t) {
                    return $t->vendor->vendor_name ?? '';
                },
                SORT_REGULAR,
                $sortDirection === 'desc',
            );

            // Convert to paginated collection
            $transactions = $transactions->values(); // reset keys
            $perPage = 15;
            $page = LengthAwarePaginator::resolveCurrentPage();
            $paged = $transactions->slice(($page - 1) * $perPage, $perPage)->all();
            $transactions = new LengthAwarePaginator($paged, $transactions->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } elseif ($sortBy === 'commission_total') {
            // Fetch all then sort manually by calculated commission
            $transactions = $query->get()->sortBy(
                function ($t) {
                    return ($t->amount * $t->commission) / 100;
                },
                SORT_REGULAR,
                $sortDirection === 'desc',
            );

            // Convert to paginated collection
            $transactions = $transactions->values(); // reset keys
            $perPage = 10;
            $page = LengthAwarePaginator::resolveCurrentPage();
            $paged = $transactions->slice(($page - 1) * $perPage, $perPage)->all();
            $transactions = new LengthAwarePaginator($paged, $transactions->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            // Standard DB-side sorting with pagination
            $transactions = $query->orderBy($sortBy, $sortDirection)->paginate(10)->appends($request->query());
        }

        // --- This Month Stats ---
        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $thisMonthTransactions = Transaction::whereBetween('date', [$thisMonthStart, $thisMonthEnd])
            ->where('status', '1')
            ->get();

        $thisMonthTransactionsCount = $thisMonthTransactions->count();
        $thisMonthAmount = $thisMonthTransactions->sum('amount');

        $thisMonthCommission = 0;
        foreach ($thisMonthTransactions as $transaction) {
            $thisMonthCommission += ($transaction->amount * $transaction->commission) / 100;
        }

        // --- Last Month Stats ---
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $lastMonthTransactions = Transaction::whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->where('status', '1')
            ->get();

        $lastMonthTransactionsCount = $lastMonthTransactions->count();
        $lastMonthAmount = $lastMonthTransactions->sum('amount');

        $lastMonthCommission = 0;
        foreach ($lastMonthTransactions as $transaction) {
            $lastMonthCommission += ($transaction->amount * $transaction->commission) / 100;
        }

        // --- % Change Calculations ---
        $transactionChange = $lastMonthTransactionsCount > 0 ? round((($thisMonthTransactionsCount - $lastMonthTransactionsCount) / $lastMonthTransactionsCount) * 100, 2) : 0;

        $amountChange = $lastMonthAmount > 0 ? round((($thisMonthAmount - $lastMonthAmount) / $lastMonthAmount) * 100, 2) : 0;

        $commissionChange = $lastMonthCommission > 0 ? round((($thisMonthCommission - $lastMonthCommission) / $lastMonthCommission) * 100, 2) : 0;
        // dd($transactionChange,$thisMonthTransactionsCount);
        return view(
            'admin.transactions.index',
            [
                'transactions' => $transactions,
                'showStats' => $showStats,
                'transactionChange' => $transactionChange,
                'amountChange' => $amountChange,
                'commissionChange' => $commissionChange,
                'thisMonthTransactionsCount' => $thisMonthTransactionsCount,
                'thisMonthAmount' => $thisMonthAmount,
                'thisMonthCommission' => $thisMonthCommission,
            ],
            compact('allVendors', 'link'),
        );
    }

    public function completedTransactions(Request $request)
    {
        $allVendors = Vendor::all();
        $link = 'admin.transactions.completed';

        $showStats = 0;
        $allowedSorts = ['id', 'amount', 'created_at', 'vendor_name', 'commission_total', 'status'];
        $sortBy = in_array($request->sort, $allowedSorts) ? $request->sort : 'created_at';
        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        // Base query
        $query = Transaction::with('vendor')
            ->whereIn('status', ['1', '2']);

        // Filters
        if ($request->has('vendor_id') && $request->vendor_id != '') {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting logic
        if ($sortBy === 'vendor_name') {
            // Fetch all then sort manually by vendor name
            $transactions = $query->get()->sortBy(
                function ($t) {
                    return $t->vendor->vendor_name ?? '';
                },
                SORT_REGULAR,
                $sortDirection === 'desc',
            );

            // Convert to paginated collection
            $transactions = $transactions->values(); // reset keys
            $perPage = 10;
            $page = LengthAwarePaginator::resolveCurrentPage();
            $paged = $transactions->slice(($page - 1) * $perPage, $perPage)->all();
            $transactions = new LengthAwarePaginator($paged, $transactions->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } elseif ($sortBy === 'commission_total') {
            // Fetch all then sort manually by calculated commission
            $transactions = $query->get()->sortBy(
                function ($t) {
                    return ($t->amount * $t->commission) / 100;
                },
                SORT_REGULAR,
                $sortDirection === 'desc',
            );

            // Convert to paginated collection
            $transactions = $transactions->values(); // reset keys
            $perPage = 10;
            $page = LengthAwarePaginator::resolveCurrentPage();
            $paged = $transactions->slice(($page - 1) * $perPage, $perPage)->all();
            $transactions = new LengthAwarePaginator($paged, $transactions->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            // Standard DB-side sorting with pagination
            $transactions = $query->orderBy($sortBy, $sortDirection)->paginate(10)->appends($request->query());
        }

        return view(
            'admin.transactions.index',
            [
                'transactions' => $transactions,
                'showStats' => $showStats,
            ],
            compact('allVendors', 'link'),
        );
    }

    public function pendingTransactions(Request $request)
    {
        $allVendors = Vendor::all();
        $link = 'admin.transactions.pending';
        $showStats = 0;

        $allowedSorts = ['id', 'amount', 'created_at', 'vendor_name', 'commission_total', 'status'];
        $sortBy = in_array($request->sort, $allowedSorts) ? $request->sort : 'created_at';
        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        // Base query
        $query = Transaction::with('vendor')
            ->where('status', '0');

        // Filters
        if ($request->has('vendor_id') && $request->vendor_id != '') {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting logic
        if ($sortBy === 'vendor_name') {
            // Fetch all then sort manually by vendor name
            $transactions = $query->get()->sortBy(
                function ($t) {
                    return $t->vendor->vendor_name ?? '';
                },
                SORT_REGULAR,
                $sortDirection === 'desc',
            );

            // Convert to paginated collection
            $transactions = $transactions->values(); // reset keys
            $perPage = 10;
            $page = LengthAwarePaginator::resolveCurrentPage();
            $paged = $transactions->slice(($page - 1) * $perPage, $perPage)->all();
            $transactions = new LengthAwarePaginator($paged, $transactions->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } elseif ($sortBy === 'commission_total') {
            // Fetch all then sort manually by calculated commission
            $transactions = $query->get()->sortBy(
                function ($t) {
                    return ($t->amount * $t->commission) / 100;
                },
                SORT_REGULAR,
                $sortDirection === 'desc',
            );

            // Convert to paginated collection
            $transactions = $transactions->values(); // reset keys
            $perPage = 10;
            $page = LengthAwarePaginator::resolveCurrentPage();
            $paged = $transactions->slice(($page - 1) * $perPage, $perPage)->all();
            $transactions = new LengthAwarePaginator($paged, $transactions->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            // Standard DB-side sorting with pagination
            $transactions = $query->orderBy($sortBy, $sortDirection)->paginate(10)->appends($request->query());
        }
        return view(
            'admin.transactions.index',
            [
                'transactions' => $transactions,
                'showStats' => $showStats,
            ],
            compact('allVendors', 'link'),
        );
    }

    public function approveTransaction($transactionId)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->status = '1';
            $transaction->save();

            return redirect()->route('admin.transactions.completed')->with('success', 'Transaction approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error changing transaction status: ' . $e->getMessage());
            return back()->with('error', 'Error updating status of the transaction.');
        }
    }

    public function rejectTransaction($transactionId)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->status = '2';
            $transaction->save();

            return redirect()->route('admin.transactions.completed')->with('success', 'Transaction rejected successfully.');
        } catch (\Exception $e) {
            \Log::error('Error changing transaction status: ' . $e->getMessage());
            return back()->with('error', 'Error updating status of the transaction.');
        }
    }

    public function receipt($id)
    {
        $transaction = Transaction::with('vendor')->findOrFail($id);
        return view('admin.transactions.receipt', compact('transaction'));
    }

    public function show($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        return view('admin.transactions.viewTransaction', compact('transaction'));
    }
}
