<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Quizmaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class QuizmasterController extends Controller{
    public function index(){
		$check_access = Gate::allows('check-access', ['QuizMaster', 'View']);
		
		if ($check_access) {
			return view('modules.quizmaster.add');
		} else {
			abort(403, 'Unauthorized');
		}
    }

    public function getData(){
        try {
            $quizmasters = Quizmaster::select(
                'id',
                'name',
                'email',
                'role',
                'bio',
                'photo',
                'status',
                'created_at',
                'updated_at'
            )->orderBy('created_at', 'desc')->get();

            return response()->json($quizmasters);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch quiz masters',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:quiz_master,email,' . $request->quizmaster_id,
            'role' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
            'quizmaster_id' => 'nullable|exists:quiz_master,id',
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
            $quizmaster = $request->quizmaster_id 
                ? Quizmaster::find($request->quizmaster_id) 
                : new Quizmaster();

            if ($request->quizmaster_id && !$quizmaster) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quiz Master not found'
                ], 404);
            }

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'bio' => $request->bio,
                'status' => $request->status,
            ];

            if ($request->hasFile('photo')) {
                if (!empty($quizmaster->photo)) {
                    $oldPath = public_path('assets/images/quizmaster/' . $quizmaster->photo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $image = $request->file('photo');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(
                    public_path('assets/images/quizmaster'),
                    $imageName
                );

                $data['photo'] = $imageName;
            }

            if (!$request->quizmaster_id) {
                $data['created_by'] = Auth::id();
                $quizmaster = Quizmaster::create($data);
                $message = 'Quiz Master created successfully';
            } else {
                $quizmaster->update($data);
                $message = 'Quiz Master updated successfully';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $quizmaster
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request){
        $quizmaster = Quizmaster::find($request->id);

        if (!$quizmaster) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz Master not found'
            ], 404);
        }

        if (!empty($quizmaster->photo)) {
            $photoPath = public_path('assets/images/quizmaster/' . $quizmaster->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $quizmaster->delete();

        return response()->json([
            'status' => true,
            'message' => 'Quiz Master deleted successfully'
        ]);
    }

    public function updateStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:Active,Inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $quizmaster = Quizmaster::findOrFail($request->id);
            $quizmaster->status = $request->status;
            $quizmaster->save();

            return response()->json([
                'status' => true,
                'message' => 'Quiz Master status updated successfully'
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