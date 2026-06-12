<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class SubscriptionController extends Controller
{
    public function subscription(){
		$check_access = Gate::allows('check-access', ['Payment', 'View']);
		if ($check_access) {
			return view('modules.subscription.subscription');
		} else {
			abort(403, 'Unauthorized');
		}
    }

    public function getSubscriptions()
    {
        try {
            $subscriptions = Subscription::orderBy('price', 'asc')->get();
            return response()->json($subscriptions);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch subscriptions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addSubscriptionAjax(Request $request)
    {
        $rules = [
            'plan_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:50',
            'features' => 'nullable|string',
            'status' => 'required|in:Active,Disabled',
            'subscription_id' => 'nullable|exists:subscription,id',
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
            $subscription = $request->subscription_id 
                ? Subscription::find($request->subscription_id) 
                : new Subscription();

            if ($request->subscription_id && !$subscription) {
                return response()->json([
                    'status' => false,
                    'message' => 'Subscription not found'
                ], 404);
            }

            $data = [
                'plan_name' => $request->plan_name,
                'price' => $request->price,
                'duration' => $request->duration,
                'features' => $request->features,
                'status' => $request->status,
            ];

            if (!$request->subscription_id) {
                $subscription = Subscription::create($data);
                $message = 'Subscription plan created successfully';
            } else {
                $subscription->update($data);
                $message = 'Subscription plan updated successfully';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $subscription
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteSubscription(Request $request)
    {
        $subscription = Subscription::find($request->id);

        if (!$subscription) {
            return response()->json([
                'status' => false,
                'message' => 'Subscription not found'
            ], 404);
        }

        $subscription->delete();

        return response()->json([
            'status' => true,
            'message' => 'Subscription plan deleted successfully'
        ]);
    }

    public function updateSubscriptionStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:Active,Disabled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $subscription = Subscription::find($request->id);
            $subscription->status = $request->status;
            $subscription->save();

            return response()->json([
                'status' => true,
                'message' => 'Subscription status updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}