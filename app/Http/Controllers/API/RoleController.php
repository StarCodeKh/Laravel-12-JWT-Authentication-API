<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        return response()->json($role, 201);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role, 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $validated['name']]);
        return response()->json($role, 200);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}