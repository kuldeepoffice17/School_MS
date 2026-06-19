<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Display a listing of fees
     */
    public function index(Request $request)
    {
        $query = Fee::with('student');
        
        // Search by student name or admission no
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%");
            });
        }
        
        // Filter by class
        if ($request->has('class_id') && $request->class_id != '') {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }
        
        // Filter by fee type
        if ($request->has('fee_type') && $request->fee_type != '') {
            $query->where('fee_type', $request->fee_type);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $fees = $query->orderBy('due_date', 'asc')->paginate(15);
        $classes = Classes::all();
        
        // Summary statistics
        $totalFees = Fee::sum('amount');
        $totalCollected = Fee::sum('paid_amount');
        $totalDue = Fee::sum('due_amount');
        $collectionRate = $totalFees > 0 ? round(($totalCollected / $totalFees) * 100, 2) : 0;
        
        return view('admin.fees.index', compact('fees', 'classes', 'totalFees', 'totalCollected', 'totalDue', 'collectionRate'));
    }

    /**
     * Show form to create new fee
     */
    public function create()
    {
        $students = Student::with(['class', 'section'])->where('status', 'active')->get();
        return view('admin.fees.create', compact('students'));
    }

    /**
     * Store a new fee
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|in:tuition,admission,exam,library,sports,transport,other',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['paid_amount'] = 0;
        $data['due_amount'] = $request->amount;
        $data['status'] = 'unpaid';

        Fee::create($data);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record created successfully.');
    }

    /**
     * Show fee details
     */
    public function show(Fee $fee)
    {
        $fee->load(['student', 'payments']);
        return view('admin.fees.show', compact('fee'));
    }

    /**
     * Show form to edit fee
     */
    public function edit(Fee $fee)
    {
        $students = Student::with(['class', 'section'])->where('status', 'active')->get();
        return view('admin.fees.edit', compact('fee', 'students'));
    }

    /**
     * Update fee
     */
    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|in:tuition,admission,exam,library,sports,transport,other',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['due_amount'] = $request->amount - $fee->paid_amount;
        $data['status'] = $fee->paid_amount >= $request->amount ? 'paid' : ($fee->paid_amount > 0 ? 'partial' : 'unpaid');

        $fee->update($data);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record updated successfully.');
    }

    /**
     * Delete fee
     */
    public function destroy(Fee $fee)
    {
        if ($fee->payments()->count() > 0) {
            return redirect()->route('admin.fees.index')
                ->with('error', 'Cannot delete fee with payment records.');
        }
        
        $fee->delete();

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record deleted successfully.');
    }

    /**
     * Add payment to fee
     */
   public function addPayment(Request $request, Fee $fee)
{
    $request->validate([
        'amount' => 'required|numeric|min:1|max:' . $fee->due_amount,
        'payment_date' => 'required|date',
        'payment_method' => 'required|in:cash,card,cheque,online,bank_transfer',
        'remarks' => 'nullable|string'
    ]);

    DB::beginTransaction();
    
    try {
        // Generate receipt number
        $lastPayment = Payment::orderBy('id', 'desc')->first();
        $lastNumber = $lastPayment ? intval(substr($lastPayment->receipt_no, -6)) : 0;
        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        $receiptNo = 'RCPT' . date('Y') . $newNumber;
        
        // Create payment record
        $payment = Payment::create([
            'fee_id' => $fee->id,
            'student_id' => $fee->student_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'receipt_no' => $receiptNo,
            'remarks' => $request->remarks
        ]);
        
        // Update fee
        $fee->paid_amount = $fee->paid_amount + $request->amount;
        $fee->due_amount = $fee->amount - $fee->paid_amount;
        $fee->status = $fee->paid_amount >= $fee->amount ? 'paid' : 'partial';
        $fee->save();
        
        DB::commit();
        
        return redirect()->route('admin.fees.show', $fee)
            ->with('success', 'Payment added successfully. Receipt No: ' . $payment->receipt_no);
            
    } catch (\Exception $e) {
        DB::rollback();
        // Log the error for debugging
        \Log::error('Payment failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
    }
}

    /**
     * Collection report
     */
    public function collectionReport(Request $request)
    {
        $fromDate = $request->from_date ?? date('Y-m-01');
        $toDate = $request->to_date ?? date('Y-m-t');
        
        $payments = Payment::with(['student', 'fee'])
            ->whereBetween('payment_date', [$fromDate, $toDate])
            ->orderBy('payment_date', 'desc')
            ->get();
        
        $totalCollected = $payments->sum('amount');
        $totalTransactions = $payments->count();
        
        $collectionByMethod = $payments->groupBy('payment_method')
            ->map(function($item) {
                return [
                    'count' => $item->count(),
                    'amount' => $item->sum('amount')
                ];
            });
        
        return view('admin.fees.collection-report', compact(
            'payments', 'totalCollected', 'totalTransactions', 
            'collectionByMethod', 'fromDate', 'toDate'
        ));
    }

    /**
     * Get student fees summary
     */
    public function studentFees(Student $student)
    {
        $fees = Fee::where('student_id', $student->id)->get();
        $totalFee = $fees->sum('amount');
        $totalPaid = $fees->sum('paid_amount');
        $totalDue = $fees->sum('due_amount');
        
        return response()->json([
            'total_fee' => $totalFee,
            'total_paid' => $totalPaid,
            'total_due' => $totalDue,
            'fees' => $fees
        ]);
    }
}