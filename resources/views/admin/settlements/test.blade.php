@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Vendor Settlements</h1>
        <p>Process commissions after every 5 transactions</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Vendors with Unsettled Transactions</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Vendor ID</th>
                            <th>Unsettled Transactions</th>
                            <th>Batches Available (5 per batch)</th>
                            <th>Potential Commissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                            <tr>
                                <td>{{ $vendor['vendor_id'] }}</td>
                                <td>{{ $vendor['unsettled_count'] }}</td>
                                <td>{{ $vendor['batches_available'] }}</td>
                                <td>{{ $vendor['potential_commissions'] }} transactions</td>
                                <td>
                                    <form action="{{ route('settlements.process') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="vendor_id" value="{{ $vendor['vendor_id'] }}">
                                        <div class="input-group">
                                            <select name="batch_count" class="form-control">
                                                @for ($i = 1; $i <= $vendor['batches_available']; $i++)
                                                    <option value="{{ $i }}">{{ $i }} batch(es)
                                                    </option>
                                                @endfor
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    Process
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No vendors with sufficient unsettled transactions
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Recent Commission Payouts</h3>
            </div>
            <div class="card-body">
                {{-- @php
                    $commissions = App\Models\Commission::orderBy('processed_at', 'desc')->limit(10)->get();
                @endphp --}}

                @if ($commissions->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Vendor ID</th>
                                <th>Amount</th>
                                <th>Transactions</th>
                                <th>Processed At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->vendor_id }}</td>
                                    <td>{{ number_format($commission->amount, 2) }}</td>
                                    <td>{{ $commission->transaction_count }}</td>
                                    <td>{{ $commission->processed_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ ucfirst($commission->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No commission payouts have been processed yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
