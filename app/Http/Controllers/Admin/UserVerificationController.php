<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVerificationController extends Controller
{
    public function index()
    {
        // Only admin can access
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $pendingUsers = User::where('is_verified', false)
            ->where('role', '!=', 'admin')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        $verifiedUsers = User::where('is_verified', true)
            ->where('role', '!=', 'admin')
            ->orderBy('verified_at', 'desc')
            ->paginate(20);

        return view('admin.users.verification', compact('pendingUsers', 'verifiedUsers'));
    }

    public function verify(Request $request, User $user)
    {
        try {
            // Only admin can verify
            if (!Auth::user()->isAdmin()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
            }

            $user->update([
                'is_verified' => true,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'rejection_reason' => null
            ]);

            return response()->json(['success' => true, 'message' => 'User verified successfully.']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function reject(Request $request, User $user)
    {
        try {
            // Only admin can reject
            if (!Auth::user()->isAdmin()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
            }

            $request->validate([
                'reason' => 'required|string|min:10|max:500'
            ]);

            $user->update([
                'rejection_reason' => $request->reason,
                'is_verified' => false,
                'verified_by' => null,
                'verified_at' => null
            ]);

            return response()->json(['success' => true, 'message' => 'User rejected successfully.']);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function delete(User $user)
    {
        try {
            // Only admin can delete
            if (!Auth::user()->isAdmin()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
            }

            if ($user->role == 'admin') {
                return response()->json(['success' => false, 'error' => 'Cannot delete admin user'], 400);
            }

            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}