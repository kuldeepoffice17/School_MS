@extends('layouts.admin')

@section('title', 'Fee Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fee Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted">Student</label>
                        <p><strong>{{ $fee->student->full_name ?? 'N/A' }}</strong><br>
                        <small>Admission No: {{ $fee->student->admission_no ?? 'N/A' }}</small></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Class - Section</label>
                        <p>{{ $fee->student->class->name ?? 'N/A' }} - {{ $fee->student->section->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Fee Type</label>
                        <p>{!! $fee->fee_type_badge_attribute !!}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Total Amount</label>
                        <p><strong>₹{{ number_format($fee->amount, 2) }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Paid Amount</label>
                        <p class="text-success"><strong>₹{{ number_format($fee->paid_amount, 2) }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Due Amount</label>
                        <p class="text-danger"><strong>₹{{ number_format($fee->due_amount, 2) }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Due Date</label>
                        <p>{{ date('d M Y', strtotime($fee->due_date)) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Status</label>
                        <p>{!! $fee->status_badge_attribute !!}</p>
                    </div>
                    @if($fee->description)
                    <div class="mb-3">
                        <label class="text-muted">Description</label>
                        <p>{{ $fee->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Add Payment Form -->
            @if($fee->status != 'paid')
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Payment</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.fees.payment', $fee) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Amount *</label>
                                    <input type="number" step="0.01" name="amount" class="form-control" 
                                           max="{{ $fee->due_amount }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Payment Date *</label>
                                    <input type="date" name="payment_date" class="form-control" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Payment Method *</label>
                                    <select name="payment_method" class="form-control" required>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="online">Online</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Transaction ID</label>
                                    <input type="text" name="transaction_id" class="form-control" placeholder="Optional">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Remarks</label>
                                    <input type="text" name="remarks" class="form-control" placeholder="Optional">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Add Payment
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            <!-- Payment History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment History</h6>
                </div>
                <div class="card-body">
                    @if($fee->payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Receipt No</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Transaction ID</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fee->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->receipt_no }}</td>
                                        <td>{{ date('d M Y', strtotime($payment->payment_date)) }}</td>
                                        <td>₹{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>{{ $payment->transaction_id ?? '-' }}</td>
                                        <td>{{ $payment->remarks ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No payments recorded yet.</p>
                    @endif
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-primary">Edit Fee</a>
                    <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection