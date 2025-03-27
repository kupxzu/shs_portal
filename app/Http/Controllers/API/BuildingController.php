<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return response()->json([
            'status' => 'success',
            'data' => $buildings
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'building_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $building = Building::create([
            'building_name' => $request->building_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Building created successfully',
            'data' => $building
        ], 201);
    }

    public function show($id)
    {
        $building = Building::find($id);
        
        if (!$building) {
            return response()->json([
                'status' => 'error',
                'message' => 'Building not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $building
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $building = Building::find($id);
        
        if (!$building) {
            return response()->json([
                'status' => 'error',
                'message' => 'Building not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'building_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $building->building_name = $request->building_name;
        $building->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Building updated successfully',
            'data' => $building
        ], 200);
    }

    public function destroy($id)
    {
        $building = Building::find($id);
        
        if (!$building) {
            return response()->json([
                'status' => 'error',
                'message' => 'Building not found'
            ], 404);
        }

        $building->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Building deleted successfully'
        ], 200);
    }
}