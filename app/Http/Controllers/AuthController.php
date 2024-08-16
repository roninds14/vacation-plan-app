<?php

namespace App\Http\Controllers;

use App\Http\Services\IAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	protected $service;

	public function __construct(IAuthService $service)
	{
		$this->service = $service;
	}

	public function login(Request $request)
	{
		return $this->service->login($request);
	}

	public function register(Request $request)
	{
		return $this->service->register($request);
	}
}
