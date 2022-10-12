<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserResource;

class UserController extends BaseController {

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:50',
                    'description' => 'required|max:250',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                    'email' => 'required|unique:users|max:255|email',
                    'password' => 'required|min:8',
                    'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $input['image'] = url('images/' . $imageName);
            $request->image->move(public_path('images'), $imageName);
        }

        $user = User::create($input);
        $success['name'] = $user->name;
        $success['description'] = $user->description;
        $success['email'] = $user->email;
        $success['image'] = $user->image;
        return $this->sendResponse($success, 'User registered successfully.');
    }

    public function index(Request $request) {
        $page = $request->has('page') ? $request->get('page') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 2;
        $users = User::limit($limit)->offset(($page - 1) * $limit)->get();
        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    public function show($id) {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

}
