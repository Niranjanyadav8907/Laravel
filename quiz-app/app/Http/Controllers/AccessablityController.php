<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Accessibility;
use Illuminate\Http\Request;

class AccessablityController extends Controller
{
	
	public function addAccessablity(){
		return view('modules.accessibility.all');
	}
	
	public function getRolesForAccessablitySave(Request $request){
		$id = $request->id;

		$roles = Role::select('id', 'role_name')->where('id' , '!=' , 1)->get();

		if($roles && $roles->count() > 0){
			$accessibilities = Accessibility::all(); 

			return response()->json([
				'status' => true,
				'roles' => $roles,
				'accessibilities' => $accessibilities
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => 'No roles found.'
			]);
		}
	}
	
	public function getRolesForAccess(Request $request){
        $roles = Role::all();
        return response()->json([
            'status' => true,
            'roles' => $roles
        ]);
    }

    public function saveAccess(Request $request){
        $accessData = $request->accessData;

        if (!$accessData || !is_array($accessData)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid data.'
            ]);
        }

        foreach ($accessData as $item) {
            $role = Role::where('role_name', $item['role'])->first();
            if (!$role) continue;

            Accessibility::updateOrCreate(
                [
                    'role_id' => $role->id,
                    'module' => $item['module'],
                    'action' => $item['action']
                ],
                ['access' => $item['access']]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Access permissions saved successfully!'
        ]);
    }

	
}


