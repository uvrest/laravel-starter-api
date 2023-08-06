<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest\AvatarUpdateRequest;
use App\Http\Requests\UserAuthRequest\LoginRequest;
use App\Http\Requests\UserAuthRequest\UserRegisterRequest;
use App\Http\Requests\UserAuthRequest\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function updateAvatar(AvatarUpdateRequest $request)
    {
        $user = $request->user();

        // Check if the user has an old avatar and delete it
        if ($user->avatar_thumbnail) {
            $oldAvatarPath = parse_url($user->avatar_thumbnail, PHP_URL_PATH);
            $oldAvatarPath = ltrim($oldAvatarPath, '/');
            Storage::delete($oldAvatarPath);
        }

        // Store the new avatar
        $avatarPath = $request->file('avatar_thumbnail')->store('users/avatar', 'public');
        $user->avatar_thumbnail = Storage::url($avatarPath);
        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Avatar updated successfully'
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated()))
        {
            return response()->json([
                'message' => 'Login inválido.'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token_of_' . $user->id . '_' . strtolower(str_replace(' ', '_', $user->name)))->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke all tokens...
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();

        //Verify if the user sent an avatar file
        if ($request->hasFile('avatar_thumbnail')) {
            $avatarPath = $request->file('avatar_thumbnail')->store('users/avatar', 'public');
            $validatedData['avatar_thumbnail'] = Storage::url($avatarPath);
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        $token = $user->createToken('auth_token_of_' . $user->id . '_' . strtolower(str_replace(' ', '_', $user->name)))->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();

        $validatedData = $request->validated();

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'user' => $user,
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Check if the user has an avatar
        if ($user->avatar_thumbnail) {
            // Get the path of the avatar from its URL
            $avatarPath = parse_url($user->avatar_thumbnail, PHP_URL_PATH);

            // Remove the leading '/' from the path
            $avatarPath = ltrim($avatarPath, '/');

            // Delete the avatar
            Storage::delete($avatarPath);
        }

        // Delete the user
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
