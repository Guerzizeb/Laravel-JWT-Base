<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait RestControllerTrait {

	use ResponseTrait;
	
	public function index() {
		$m = self::MODEL;
		return $this->listResponse($m::all());
	}

	public function show($id) {
		$m = self::MODEL;
		if($data = $m::find($id)) {
			return $this->showResponse($data);
		}

		return $this->notFoundResponse();
	}

	public function store(Request $request) {
		$m = self::MODEL;
		try {
			$v = \Validator::make($request->all(), $this->validationRules);
			if($v->fails()) {
				throw new \Exception("ValidationException");
			}

			$data = $m::create($request->all());
			return $this->createdResponse($data);

		} catch(\Exception $ex) {
			$data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
			return $this->clientErrorResponse($data);
		}
	}

	public function update(Request $request, $id) {
		$m = self::MODEL;
		if(!$data = $m::find($id)) {
			return $this->notFoundResponse();   
		}

		try {
			$v = \Validator::make($request->all(), $this->validationRules);
			if($v->fails()) {
				throw new \Exception("ValidationException");
			}

			$data->fill($request->all());
			$data->save();
			
			return $this->showResponse($data);
		} catch(\Exception $ex) {
			$data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
			return $this->clientErrorResponse($data);
		}
	}

	public function destroy($id) {
		$m = self::MODEL;
		if(!$data = $m::find($id)) {
			return $this->notFoundResponse();   
		}
		
		$data->delete();
		return $this->deletedResponse();
	}

}