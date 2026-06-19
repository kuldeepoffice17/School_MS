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
                        <label class="text-muted">Student Name</label>
                        <p><strong>{{ $fee->student->first_name ?? 'N/A' }} {{ $fee->student->last_name ?? '' }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Admission Number</label>
                        <p>{{ $fee->student->admission_no ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Class - Section</label>
                        <p>{{ $fee->student->class->name ?? 'N/A' }} - {{ $fee->student->section->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Fee Type</label>
                        <p>
                            @if($fee->fee_type == 'tuition') Tuition Fee
                            @elseif($fee->fee_type == 'admission') Admission Fee
                            @elseif($fee->fee_type == 'exam') Exam Fee
                            @elseif($fee->fee_type == 'library') Library Fee
                            @elseif($fee->fee_type == 'sports') Sports Fee
                            @elseif($fee->fee_type == 'transport') Transport Fee
                            @else Other
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Total Amount</label>
                        <h4>₹{{ number_format($fee->amount, 2) }}</h4>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Paid Amount</label>
                        <h5 class="text-success">₹{{ number_format($fee->paid_amount, 2) }}</h5>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Due Amount</label>
                        <h5 class="text-danger">₹{{ number_format($fee->due_amount, 2) }}</h5>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Due Date</label>
                        <p>{{ date('d M Y', strtotime($fee->due_date)) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Status</label>
                        <p>
                            @if($fee->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($fee->status == 'partial')
                                <span class="badge bg-warning">Partial</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </p>
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
                                           placeholder="Enter amount" max="{{ $fee->due_amount }}" required>
                                    <small class="text-muted">Max: ₹{{ number_format($fee->due_amount, 2) }}</small>
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
                                        <option value="">Select Method</option>
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
                    @if($fee->payments && $fee->payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Receipt No</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
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
                                        <td>
                                            @if($payment->payment_method == 'cash') Cash
                                            @elseif($payment->payment_method == 'card') Card
                                            @elseif($payment->payment_method == 'cheque') Cheque
                                            @elseif($payment->payment_method == 'online') Online
                                            @else Bank Transfer
                                            @endif
                                        </td>
                                        <td>{{ $payment->transaction_id ?? '-' }}</td>
                                        <td>{{ $payment->remarks ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No payments recorded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Fee
                    </a>
                    <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection