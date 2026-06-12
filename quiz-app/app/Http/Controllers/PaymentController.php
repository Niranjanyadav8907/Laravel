<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class PaymentController extends Controller
{
    public function payment(){
    $check_access = Gate::allows('check-access', ['Plans', 'View']);
    if ($check_access) {
        $subscriptions = Subscription::where('status', 'Active')->get();
        $users = User::select('id', 'name', 'email')->get();
        return view('modules.subscription.payment', compact('subscriptions', 'users'));
    } else {
        abort(403, 'Unauthorized');
    }
}

    public function getPayments(Request $request)
    {
        try {
            $query = Payment::query();

            if ($request->filled('user')) {
                $user = $request->user;
                $query->where(function($q) use ($user) {
                    $q->where('user_name', 'LIKE', "%{$user}%")
                      ->orWhere('user_email', 'LIKE', "%{$user}%");
                });
            }

            if ($request->filled('plan')) {
                $query->where('plan_name', $request->plan);
            }

            if ($request->filled('status')) {
                $query->where('payment_status', $request->status);
            }

            $payments = $query->orderBy('created_at', 'desc')->get();

            return response()->json($payments);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch payments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addPaymentAjax(Request $request)
    {
        $rules = [
            'plan_id' => 'required|exists:subscription,id',
            'payment_status' => 'required|in:Active,Pending,Expired,Cancelled',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'payment_id' => 'nullable|exists:payment,id',
            'user_name_input' => 'required|string|max:255',
            'user_email_input' => 'required|email|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userId = $request->user_id;
            $userName = $request->user_name_input;
            $userEmail = $request->user_email_input;
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $userName = $user->name;
                    $userEmail = $user->email;
                }
            }

            $subscription = Subscription::find($request->plan_id);

            if (!$subscription) {
                return response()->json([
                    'status' => false,
                    'message' => 'Subscription not found'
                ], 404);
            }

            $payment = $request->payment_id ? Payment::find($request->payment_id) : new Payment();

            if ($request->payment_id && !$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            // Calculate dates
            $startDate = now();
            $endDate = $this->calculateEndDate($startDate, $subscription->duration);

            $data = [
                'user_id' => $userId ?? null,
                'user_name' => $userName,
                'user_email' => $userEmail,
                'plan_id' => $subscription->id,
                'plan_name' => $subscription->plan_name,
                'plan_duration' => $subscription->duration,
                'amount' => $subscription->price,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method ?? 'Manual',
                'payment_type' => 'Manual',
                'transaction_id' => $request->transaction_id ?? 'MANUAL_' . time(),
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];

            if (!$request->payment_id) {
                $payment = Payment::create($data);
                $message = 'Payment added successfully';
            } else {
                $payment->update($data);
                $message = 'Payment updated successfully';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $payment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deletePayment(Request $request)
    {
        $payment = Payment::find($request->id);

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Payment deleted successfully'
        ]);
    }

    public function getPaymentDetails(Request $request)
    {
        try {
            $payment = Payment::find($request->id);

            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            $html = view('modules.subscription.partials.payment-details', compact('payment'))->render();

            return response()->json([
                'status' => true,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to load payment details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function renewPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:payment,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid payment ID'
            ], 422);
        }

        try {
            $payment = Payment::find($request->id);

            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            $startDate = now();
            $endDate = $this->calculateEndDate($startDate, $payment->plan_duration);

            $payment->update([
                'payment_status' => 'Active',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'renewed_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subscription renewed successfully',
                'data' => $payment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to renew subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:payment,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid payment ID'
            ], 422);
        }

        try {
            $payment = Payment::find($request->id);

            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            $payment->update([
                'payment_status' => 'Cancelled',
                'cancelled_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subscription cancelled successfully',
                'data' => $payment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approvePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:payment,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid payment ID'
            ], 422);
        }

        try {
            $payment = Payment::find($request->id);

            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            if ($payment->payment_status !== 'Pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Only pending payments can be approved'
                ], 400);
            }

            $payment->update([
                'payment_status' => 'Active',
                'approved_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Payment approved successfully',
                'data' => $payment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to approve payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    //add new function 
    public function searchUsers(Request $request)
    {
        try {
            $search = $request->search;
            
            $users = User::where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->select('id', 'name', 'email')
                        ->limit(10)
                        ->get();

            return response()->json([
                'status' => true,
                'users' => $users
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to search users',
                'users' => []
            ], 500);
        }
    }

    public function exportPayments(Request $request)
    {
        try {
            $query = Payment::query();

            if ($request->filled('user')) {
                $user = $request->user;
                $query->where(function($q) use ($user) {
                    $q->where('user_name', 'LIKE', "%{$user}%")
                      ->orWhere('user_email', 'LIKE', "%{$user}%");
                });
            }

            if ($request->filled('plan')) {
                $query->where('plan_name', $request->plan);
            }

            if ($request->filled('status')) {
                $query->where('payment_status', $request->status);
            }

            $payments = $query->orderBy('created_at', 'desc')->get();

            $filename = 'payments_' . date('Y-m-d_His') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function() use ($payments) {
                $file = fopen('php://output', 'w');
                fputcsv($file, [
                    'ID',
                    'User Name',
                    'User Email',
                    'Plan Name',
                    'Payment Status',
                    'Payment Type',
                    'Start Date',
                    'End Date',
                    'Amount',
                    'Transaction ID',
                    'Created At'
                ]);

                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->id,
                        $payment->user_name,
                        $payment->user_email,
                        $payment->plan_name,
                        $payment->payment_status,
                        $payment->payment_type,
                        $payment->start_date,
                        $payment->end_date,
                        $payment->amount,
                        $payment->transaction_id,
                        $payment->created_at
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export payments');
        }
    }

    private function calculateEndDate($startDate, $duration)
    {
        $date = new \DateTime($startDate);

        switch ($duration) {
            case 'month':
            case 'Monthly':
                $date->modify('+1 month');
                break;
            case 'year':
            case 'Yearly':
                $date->modify('+1 year');
                break;
            case 'lifetime':
            case 'Lifetime':
                $date->modify('+100 years');
                break;
            default:
                $date->modify('+1 month');
        }

        return $date->format('Y-m-d');
    }
}
