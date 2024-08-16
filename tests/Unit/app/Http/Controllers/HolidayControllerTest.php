<?php

namespace Tests\Unit\app\Http\Controllers;

use Tests\TestCase;
use App\Http\Controllers\HolidayController;
use App\Http\Services\IHolidayService;
use Illuminate\Http\Request;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayControllerTest extends TestCase
{
	public function test_index()
	{
		//Arrange
		$serviceMock = Mockery::mock(IHolidayService::class);
		$serviceMock->shouldReceive('index')
			->once()
			->andReturn('holiday list');

		$controller = new HolidayController($serviceMock);

		//Act
		$response = $controller->index();

		//Assert
		$this->assertEquals('holiday list', $response);
	}

	public function test_store()
	{
		//Arrange
		$serviceMock = Mockery::mock(IHolidayService::class);

		$request = Request::create('/holidays', 'POST', [
			'name' => 'New Year',
			'date' => '2024-01-01',
		]);

		$serviceMock->shouldReceive('store')
			->once()
			->with($request)
			->andReturn('holiday created');

		$controller = new HolidayController($serviceMock);

		//Act
		$response = $controller->store($request);

		//Assert
		$this->assertEquals('holiday created', $response);
	}

	public function test_show()
	{
		//Arrange
		$serviceMock = Mockery::mock(IHolidayService::class);
		$id = '1';

		$serviceMock->shouldReceive('show')
			->once()
			->with($id)
			->andReturn('holiday details');

		$controller = new HolidayController($serviceMock);

		//Act
		$response = $controller->show($id);

		//Assert
		$this->assertEquals('holiday details', $response);
	}

	public function test_update()
	{
		//Arrange
		$serviceMock = Mockery::mock(IHolidayService::class);

		$request = Request::create('/holidays/1', 'PUT', [
			'name' => 'Updated Holiday',
			'date' => '2024-01-02',
		]);

		$id = '1';

		$serviceMock->shouldReceive('update')
			->once()
			->with($request, $id)
			->andReturn('holiday updated');

		$controller = new HolidayController($serviceMock);

		//Act
		$response = $controller->update($request, $id);

		//Assert
		$this->assertEquals('holiday updated', $response);
	}

	public function test_destroy()
	{
		//Arrange
		$serviceMock = Mockery::mock(IHolidayService::class);
		$id = '1';

		$serviceMock->shouldReceive('destroy')
			->once()
			->with($id)
			->andReturn('holiday deleted');

		$controller = new HolidayController($serviceMock);

		//Act
		$response = $controller->destroy($id);

		//Assert
		$this->assertEquals('holiday deleted', $response);
	}

	public function test_exportPdf()
	{
		//Arrange
		$serviceMock = Mockery::mock(IHolidayService::class);

		$serviceMock->shouldReceive('exportPdf')
			->once()
			->andReturn('pdf exported');

		$controller = new HolidayController($serviceMock);

		//Act
		$response = $controller->exportPdf();

		//Assert
		$this->assertEquals('pdf exported', $response);
	}

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
