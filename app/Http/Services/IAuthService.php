<?php

namespace App\Http\Services;
use Illuminate\Http\Request;

interface IAuthService {
	public function login(Request $request);

	public function register(Request $request);
}