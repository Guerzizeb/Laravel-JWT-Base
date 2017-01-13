<?php

namespace App\Http\Controllers;

use App\Events\UserAdded;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller {

	use ResponseTrait;

	public function index(Request $request) {

        if (!empty($request->json('role'))) {
            $users = User::where('role', $request->json('role'))->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        return $this->listResponse($users);
	}

	public function show($id) {
		if($data = User::find($id)) {
			return $this->showResponse($data);
		}

		return $this->notFoundResponse();
	}

	public function store(Request $request) {

	    try {
			$v = \Validator::make($request->all(), [
					'name' => "required|min:3|unique:users",
					'email' => 'required|email|unique:users,email',
					'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required'
				]);

			if($v->fails()) {
				throw new \Exception("ValidationException");
			}

			$user = User::create([
			    'name' => $request->json('name'),
                'email' => $request->json('email'),
                'password' => bcrypt($request->json('password'))
                ]);

            event(new UserAdded());

			return $this->createdResponse($user);

		} catch(\Exception $ex) {
			$data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
			return $this->clientErrorResponse($data);
		}
	}

	public function update(Request $request, $id) {
		if (!$user = User::find($id)) {
			return $this->notFoundResponse();   
		}

		try {
			$v = \Validator::make($request->all(), [
					'name' => "required|min:3|unique:users,name,$id",
					'email' => "required|email|unique:users,email,$id",
					'password' => 'min:6|confirmed'
				]);

			if($v->fails()) {
				throw new \Exception("ValidationException");
			}

			if ($user->name != $request->json('name')) {
			    $user->name = $request->json('name');
            }
            if ($user->email != $request->json('email')) {
                $user->email = $request->json('email');
            }
            if ($request->json('password')) {
                $user->password = bcrypt($request->json('password'));
            }

			$user->save();
			
			return $this->showResponse($user);
		} catch(\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
			return $this->clientErrorResponse($data);
		}
	}

	public function destroy($id) {
		if(!$data = User::find($id)) {
			return $this->notFoundResponse();   
		}

		$data->delete();
		return $this->deletedResponse();
	}

	public function contacts($id)  {
		if(!$user = User::find($id)) {
			return $this->notFoundResponse();   
		}

		$data = $user->contacts;
		return $this->listResponse($data);
	}

}