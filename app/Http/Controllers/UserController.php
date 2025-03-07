<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection (User::query()->orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store (StoreUserRequest $request)
    {
       // $data= $request->validated();
        
       // $user=User::create($data);

       // return response(new UserResource($user), 201);

        $user= User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,

        ]);

       return response(new UserResource($user) , 201);
        //return response(compact('user'));

       //return response()->json([

         //   "msg"=> "agregado con exito",
        //]);
        
       
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        
        if (isset($data['password'])) {
            $data['password'] = $data['password'];
        }

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response("", 204);
    }
}
