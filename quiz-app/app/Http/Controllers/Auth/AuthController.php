<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Mail\WelcomeMail;                    
use Illuminate\Support\Facades\Mail; 

class AuthController extends Controller
{
    
	public function welcome(){
		return view('home');
	}
	
	public function showLogin(){
		$user = auth()->user();
		
		if (!$user) {
			return view('auth.login');
		}
		
		$logged_user = User::find($user->id);
		
		if($logged_user->role == 1 || $logged_user->role == 2 || $logged_user->role == 4){
			return redirect()->route('admin.dashboard');
		}else if($logged_user->role == 3){
			return redirect()->route('user.dashboard');
		}else{
			return redirect()->route('welcome')->with('success', 'User Access Granted!');
		}
	}
	
	public function showRegistration(){
		return view('auth.register');
	}
	
	public function ajaxRegister(Request $request){
		if($request->id != ''){ 
		
			$validator = \Validator::make(
				$request->all(),
				[
					'name'     => 'required|string|max:255',
				]
			);
			
			if ($validator->fails()) {
				return response()->json([
					'status' => false,
					'errors' => $validator->errors()
				], 422);
			}
			
			$user = User::findOrFail($request->id);
			$user->name  = $request->name;
			$user->save();
			
			return response()->json([
				'status'  => true,
				'message' => 'User update successfully'
			]);
		}else{
			$validator = \Validator::make(
				$request->all(),
				[
					'name'     => 'required|string|max:255',
					'email'    => 'required|email|unique:users,email',
					'password' => 'required|min:6',
				],
				[
					'email.unique' => 'This email is already registered. Please login.',
				]
			);

			if ($validator->fails()) {
				return response()->json([
					'status' => false,
					'errors' => $validator->errors()
				], 422);
			}
			
			$status = 'inactive';
			if($request->is_inactive){
				$status = 'active';
			}

			$user = User::create([
				'name'                 => $request->name,
				'email'                => $request->email,
				'password'             => Hash::make($request->password),
				'agree_term_condition' => $request->is_inactive,
				'status'               => $status,
				'role'                 => 3,
			]);

			Mail::to($user->email)->send(new WelcomeMail($user));

			return response()->json([
				'status'  => true,
				'message' => 'User registered successfully'
			]);  
		}
		
	}
	
	
	
	public function ajaxLogin(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required|min:6',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$credentials = $request->only('email', 'password');
		$remember = $request->has('rememberMe') ? true : false;

		if (Auth::attempt($credentials, $remember)) {
			$request->session()->regenerate();

			$user = Auth::user();
			
			$logged_user = User::find($user->id);
			
			if($logged_user->role == 1 || $logged_user->role == 2 || $logged_user->role == 4){
				$redirectUrl = route('admin.dashboard');
			}else{
				$redirectUrl = route('welcome');
			}

			return response()->json([
				'status' => true,
				'message' => 'Login successful',
				'redirect' => $redirectUrl
			]);
		} 

		return response()->json([
			'status' => false,
			'errors' => ['email' => ['Invalid email or password']]
		], 422);
	}
	
	public function logout(Request $request){
        Auth::logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
		return redirect()->route('showLogin')->with('success', 'Logged out successfully!');
    }

	
}