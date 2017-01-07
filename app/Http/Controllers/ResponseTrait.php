<?php

namespace App\Http\Controllers;

trait ResponseTrait {

	protected function createdResponse($data) {
		$response = [
			'code' => 201,
			'status' => 'succcess',
			'item' => $data
		];
		
		return response()->json($response, $response['code']);
	}

	protected function showResponse($data) {
		$response = [
			'code' => 200,
			'status' => 'succcess',
			'item' => $data
		];
		
		return response()->json($response, $response['code']);
	}

	protected function listResponse($data) {
		$response = [
			'code' => 200,
			'status' => 'succcess',
			'items' => $data
		];

		return response()->json($response, $response['code']);
	}
	protected function notFoundResponse() {
		$response = [
			'code' => 404,
			'status' => 'error',
			'data' => 'Resource Not Found',
			'message' => 'Not Found'
		];

		return response()->json($response, $response['code']);
	}

	protected function deletedResponse() {
		$response = [
			'code' => 204,
			'status' => 'success',
			'item' => [],
			'message' => 'Resource deleted'
		];

		return response()->json($response, $response['code']);
	}

	protected function clientErrorResponse($data) {
		$response = [
			'code' => 422,
			'status' => 'error',
			'item' => $data,
			'message' => 'Unprocessable entity'
		];

		return response()->json($response, $response['code']);
	}
		
}
