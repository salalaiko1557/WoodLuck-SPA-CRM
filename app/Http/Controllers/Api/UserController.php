<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function all()
    {
        return UserResource::collection(User::all());
    }
    public function show(User $user)
    {
        return new UserResource($user);
    }
    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name'    => '',
            'email' => '',
            'password'   => '',
            'role'   => '',
        ]);

        $user->update($data);

        return new UserResource($user);
    }
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }
    public function create(User $user, Request $request)
    {
        if($request){
            $name = $request->name;
            $email = $request->email;
            $pass = bcrypt($request->password);
            $role = $request->role;

            $user->create([
                'name' => $name,
                'email' => $email,
                'password' => $pass,
                'role' => $role
            ]);

            return new UserResource($user);
        }
    }
}
