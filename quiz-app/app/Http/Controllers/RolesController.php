<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
	
	public function allRole(){
		return view('modules.role.all');
	}
	
	public function getRoles(){
        $roles = Role::orderBy('id', 'desc')->get(); 
        return response()->json($roles);
    }
	
	public function addRoleAjax(Request $request){
		$validator = Validator::make($request->all(), [
			'role_name' => 'required|string|max:255',
			'status'    => 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$existingRole = Role::where('role_name', $request->role_name)->first();
		if ($existingRole) {
			return response()->json([
				'status' => false,
				'message' => 'Role name already exists'
			], 409); 
		}

		$role = new Role();
		$role->role_name      = $request->role_name;
		$role->role_slug      = $request->role_slug ? $request->role_slug : $request->role_name;
		$role->description    = $request->description;
		$role->status         = $request->status;
		$role->is_system_role = $request->is_system_role ?? 0;
		$role->save();

		return response()->json([
			'status'  => true,
			'message' => 'Role created successfully'
		]);
	}

	public function delete(Request $request){
        $role = Role::find($request->id);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found'
            ], 404);
        }

        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role delete successfully'
        ]);
    }
	
	public function roleStatusUpdate(Request $request){
		$request->validate([
			'id' => 'required',
			'status' => 'required',
		]);

		try {
			$role = Role::findOrFail($request->id);
			$role->status = $request->status;
			$role->save();

			return response()->json([
				'status' => true,
				'message' => 'Role status updated successfully',
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'message' => 'Something went wrong: ' . $e->getMessage(),
			], 500);
		}
	}
	
	
	
}


