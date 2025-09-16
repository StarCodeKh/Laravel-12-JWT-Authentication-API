<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // List all users
    public function index() {
        return response()->json(User::all(), 200);
    }

    // Create user
    public function store(Request $request) {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    // Show user
    public function show($id) {
        return response()->json(User::findOrFail($id), 200);
    }

    // Update user
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $request->validate([
            'name'=>'sometimes|string|max:255',
            'email'=>['sometimes','email',Rule::unique('users')->ignore($user->id)],
            'password'=>'sometimes|string|min:6',
        ]);

        $user->update([
            'name'=>$request->name ?? $user->name,
            'email'=>$request->email ?? $user->email,
            'password'=>$request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json($user, 200);
    }

    // Delete user
    public function destroy($id) {
        User::findOrFail($id)->delete();
        return response()->json(['message'=>'User deleted successfully'], 200);
    }
}
