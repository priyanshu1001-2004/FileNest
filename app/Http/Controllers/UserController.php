<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(Request $request)
    {
        try {
            // FIXED: Added Validator class name before the double colons
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'admin_id' => 'required|exists:users,id',
                'password' => 'required|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $admin = User::findOrFail($request->admin_id);

            $admin->password = Hash::make($request->password);
            $admin->save();

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        try {

            $request->validate([
                'model' => 'required',
                'id'    => 'required|integer'
            ]);

            $modelClass = "App\\Models\\" . $request->model;

            if (!class_exists($modelClass)) {
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }

            $record = $modelClass::findOrFail($request->id);

            $record->status = !$record->status;
            $record->save();

            return response()->json([
                'status' => $record->status,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|in:0,1', // Added to capture your new status field
        ]);

        $user->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'User details updated successfully!'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User account deleted successfully!'
        ]);
    }
}
