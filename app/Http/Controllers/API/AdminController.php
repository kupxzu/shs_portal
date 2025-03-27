<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return response()->json([
            'status' => 'success',
            'data' => $admins
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $admin = Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin created successfully',
            'data' => $admin
        ], 201);
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        
        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $admin
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        
        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email|unique:admins,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        if ($request->has('email')) {
            $admin->email = $request->email;
        }
        
        if ($request->has('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Admin updated successfully',
            'data' => $admin
        ], 200);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        
        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin not found'
            ], 404);
        }

        $admin->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Admin deleted successfully'
        ], 200);
    }
}