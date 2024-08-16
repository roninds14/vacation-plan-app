<?php

namespace Tests\Unit\app\Http\Controllers;

use Tests\TestCase;
use App\Http\Controllers\AuthController;
use App\Http\Services\IAuthService;
use Illuminate\Http\Request;
use Mockery;

class AuthControllerTest extends TestCase
{
	public function test_login()
	{
		//Arrange
		$serviceMock = Mockery::mock(IAuthService::class);

		$request = Request::create('/login', 'POST', [
			'email' => 'test@example.com',
			'password' => 'password'
		]);

		$serviceMock->shouldReceive('login')
			->once()
			->with($request)
			->andReturn('login successful');

		$controller = new AuthController($serviceMock);

		//Act
		$response = $controller->login($request);

		//Assert
		$this->assertEquals('login successful', $response);
	}

	public function test_register()
	{
		//Arrange
		$serviceMock = Mockery::mock(IAuthService::class);

		$request = Request::create('/register', 'POST', [
			'name' => 'Test User',
			'email' => 'test@example.com',
			'password' => 'password',
			'password_confirmation' => 'password'
		]);

		$serviceMock->shouldReceive('register')
			->once()
			->with($request)
			->andReturn('registration successful');

		$controller = new AuthController($serviceMock);

		//Act
		$response = $controller->register($request);

		//Assert
		$this->assertEquals('registration successful', $response);
	}

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
