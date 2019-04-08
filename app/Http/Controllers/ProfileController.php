<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Requests\Profile\ViewRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(ViewRequest $request)
    {
        $user = $request->user();

        return view('profile.index', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        // @todo send a notification when email or password is changed.
        // when email is changed, send to the previous address, obviously.

        $user->update($data);

        flash(__('Your profile has been saved :)'))->success();

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        # code...
    }
}
