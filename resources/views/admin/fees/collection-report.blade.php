@extends('layouts.admin')

@section('title', 'Fees Collection Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-file-text"></i> Fees Collection Report
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.fees.collection') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control" value="{{ $fromDate }}">
                            </div>
                            <div class="col-md-4">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control" value="{{ $toDate }}">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Generate Report
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6>Total Collections</h6>
                                    <h3>₹{{ number_format($totalCollected, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Total Transactions</h6>
                                    <h3>{{ $totalTransactions }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6>Average Payment</h6>
                                    <h3>₹{{ $totalTransactions > 0 ? number_format($totalCollected / $totalTransactions, 2) : 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collection by Method -->
                    @if(count($collectionByMethod) > 0)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold">Collection by Payment Method</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr><th>Method</th><th>Transactions</th><th>Amount</th></tr>
                                            </thead>
                                            <tbody>
                                                @foreach($collectionByMethod as $method => $data)
                                                <tr>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $method)) }}</td>
                                                    <td>{{ $data['count'] }}</td>
                                                    <td>₹{{ number_format($data['amount'], 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Payments Table -->
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">Payment Details</h6>
                        </div>
                        <div class="card-body">
                            @if($payments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="reportTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Receipt No</th>
                                                <th>Date</th>
                                                <th>Student Name</th>
                                                <th>Admission No</th>
                                                <th>Fee Type</th>
                                                <th>Amount</th>
                                                <th>Method</th>
                                                <th>Transaction ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->receipt_no }}</td>
                                                <td>{{ date('d M Y', strtotime($payment->payment_date)) }}</td>
                                                <td>{{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}</td>
                                                <td>{{ $payment->student->admission_no ?? 'N/A' }}</td>
                                                <td>{{ ucfirst($payment->fee->fee_type ?? 'N/A') }}</td>
                                                <td>₹{{ number_format($payment->amount, 2) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                                <td>{{ $payment->transaction_id ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center">No payments found for selected period.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#reportTable').DataTable({
        pageLength: 25,
        responsive: true,
        order: [[1, 'desc']]
    });
});
</script>
@endpush