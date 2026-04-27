<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {

    }


    public function show($username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        return new UserResource($user);
    }


        public function suggestions() {
            $users = User::where('id', '!=', auth()->id())
                ->inRandomOrder()
                ->limit(5)
                ->get();

            return UserResource::collection($users)->resolve();
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
