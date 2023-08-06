<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdminUserRequest\SuperAdminUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserResourceCollection(User::paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Will not function because we're already storing users in the /register in the AuthController
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SuperAdminUpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
