<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthService implements IAuthService
{
	public function login(Request $request)
	{
		$validatedData = $this->validateLoginData($request);

		if (array_key_exists('error', $validatedData)) {
			return response()->json($validatedData, 422);
		}

		if (Auth::attempt([
			"email" => $validatedData['email'],
			"password" => $validatedData['password']
		])) {
			$user = Auth::user();

			$token = $user->createToken('Personal Access Token')->accessToken;

			return response()->json([
				"status" => true,
				"message" => "User logged successfully",
				"token" => $token
			]);
		} else {
			return response()->json([
				"status" => false,
				"message" => "Invalid loging details"
			]);
		}
	}

	public function register(Request $request)
	{
		$validatedData = $this->validateRegisterData($request);

		if (array_key_exists('error', $validatedData)) {
			return response()->json($validatedData, 422);
		}

		User::create([
			"name" => $request->name,
			"email" =>  $request->email,
			"password" => Hash::make($request->password),
		]);

		return response()->json([
			"status" => 1,
			"message" => "User created successfully"
		]);
	}

	private function validateLoginData(Request $request)
	{
		$validateData = [];

		try {
			$validateData = $request->validate([
				"email" => "required|email",
				"password" => "required"
			]);
		} catch (Exception $e) {
			$validateData = [
				'error' => "Validation failed. {$e->getMessage()}",
				'data' => $request->all()
			];
		}

		return $validateData;
	}

	private function validateRegisterData(Request $request)
	{
		$validateData = [];

		try {
			$validateData = $request->validate([
				"name" => "required",
				"email" => "required|email|unique:users",
				"password" => "required|confirmed"
			]);
		} catch (Exception $e) {
			$validateData = [
				'error' => "Validation failed. {$e->getMessage()}",
				'data' => $request->all()
			];
		}

		return $validateData;
	}
}
