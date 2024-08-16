<?php

namespace Tests\Unit\app\Http\Services;

use Tests\TestCase;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\Unit\Mocks\RequestMock;
use Illuminate\Hashing\HashManager;

class AuthServiceTest extends TestCase
{
	public function test_login_successful()
	{
		//Arrange
		$request = Request::create('/login', 'POST', [
			'email' => 'test@example.com',
			'password' => 'password',
		]);

		$user = Mockery::mock(User::class);
		$user->shouldReceive('createToken')
			->andReturn((object)['accessToken' => 'test-token']);

		Auth::shouldReceive('attempt')
			->once()
			->with([
				'email' => 'test@example.com',
				'password' => 'password',
			])
			->andReturn(true);

		Auth::shouldReceive('user')
			->once()
			->andReturn($user);

		$service = new AuthService();

		//Act
		$response = $service->login($request);

		//Assert
		$this->assertTrue($response->getData()->status);
		$this->assertEquals('User logged successfully', $response->getData()->message);
		$this->assertEquals('test-token', $response->getData()->token);
	}

	public function test_login_failed()
	{
		//Arrange
		$request = Request::create('/login', 'POST', [
			'email' => 'wrong@example.com',
			'password' => 'wrongpassword',
		]);

		Auth::shouldReceive('attempt')
			->once()
			->with([
				'email' => 'wrong@example.com',
				'password' => 'wrongpassword',
			])
			->andReturn(false);

		$service = new AuthService();

		//Act
		$response = $service->login($request);

		//Assert
		$this->assertFalse($response->getData()->status);
		$this->assertEquals('Invalid loging details', $response->getData()->message);
	}

	public function test_register_successful()
	{
		//TODO

		/*
		Error o Mock User::createToken
		*/

		$this->assertTrue(true);
	}

	public function test_login_validation_failed()
	{
		//Arrange
		$request = Request::create('/login', 'POST', [
			'email' => 'invalid-email',
			'password' => '',
		]);

		$service = new AuthService();

		//Act
		$response = $service->login($request);

		//Assert
		$this->assertArrayHasKey('error', $response->getData(true));
		$this->assertEquals(
			'Validation failed. The email field must be a valid email address. (and 1 more error)',
			$response->getData(true)['error']
		);
	}

	public function test_register_validation_failed()
	{
		//Arrange
		$request = Request::create('/register', 'POST', [
			'name' => '',
			'email' => 'invalid-email',
			'password' => 'password',
			'password_confirmation' => 'mismatch',
		]);

		$service = new AuthService();

		//Act
		$response = $service->register($request);

		//Assert
		$this->assertArrayHasKey('error', $response->getData(true));
		$this->assertStringContainsString('Validation failed.', $response->getData(true)['error']);
	}

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
