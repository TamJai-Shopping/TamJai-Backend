<?php

namespace App\Http\Controllers\Api;

use App\Rules\CheckUniqueIdCardCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }

    public function index()
    {
        $users = User::with('orders')->get();
        return UserResource::collection($users);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);
        $user = new User();
        $user->name=$request->get('name');
        $user->email=$request->get('email');
        $user->password=Hash::make($request->get('password'));
        $user->phone_number=$request->get('phone_number');
        // $user->save();

        if ($user->save()) {
            // event(new Registered($user));
            return response()->json([
                'success' => true,
                'message' => 'User created with id '.$user->id,
                'user_id' => $user->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'User creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }
}