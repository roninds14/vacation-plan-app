<?php

namespace Tests\Unit\app\Http\Services;

use App\Http\Services\HolidayService;
use App\Models\Holiday;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Mockery;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class HolidayServiceTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		Auth::shouldReceive('user')->andReturn((object)['id' => 1]);
	}

	public function test_index()
	{
		//Arrange
		$dbReturn = [
			(object)['id' => 1, 'title' => 'Holiday 1'],
			(object)['id' => 2, 'title' => 'Holiday 2']
		];

		$mockHoliday = Mockery::mock('alias:' . Holiday::class);
		$mockHoliday->shouldReceive('where->with->get')
			->once()
			->andReturn($dbReturn);

		$holidayService = new HolidayService();

		//Act
		$response = $holidayService->index();

		//Assert
		$this->assertEquals(200, $response->status());
		$this->assertCount(2, $response->getData());
	}

	public function test_store()
	{
		//Arrange
		$requestData = [
			'title' => 'New Year',
			'description' => 'New Year Celebration',
			'date' => '2024-01-01',
			'location' => 'New York',
			'participants' => [
				['name' => 'John Doe'],
				['name' => 'Jane Doe']
			]
		];

		$request = Request::create('/holidays', 'POST', $requestData);

		$mockParticipant = Mockery::mock('alias:' . Participant::class);
		$mockParticipant->shouldReceive('create')
			->twice();

		$mockHoliday = Mockery::mock('alias:' . Holiday::class);
		$mockHoliday->shouldReceive('participants')
			->twice()
			->andReturn(
				$mockParticipant
			);

		$mockHoliday->shouldReceive('create')
			->once()
			->andReturn($mockHoliday);

		$mockHoliday->shouldReceive('with->find')
			->once();
		$mockHoliday->id = 1;

		$holidayService = new HolidayService();

		//Act
		$response = $holidayService->store($request);

		//Assert
		$this->assertEquals(201, $response->status());
	}

	public function test_show()
	{
		//Arrange
		$mockHoliday = Mockery::mock('alias:' . Holiday::class);
		$mockHoliday->shouldReceive('with->where->where->get')
			->once()
			->andReturn([(object)['id' => 1, 'title' => 'Holiday 1']]);

		$holidayService = new HolidayService();

		//Act
		$response = $holidayService->show(1);

		//Assert
		$this->assertEquals(200, $response->status());
		$this->assertEquals(1, $response->getData()[0]->id);
	}

	public function test_update()
	{
		//Arrange
		$request = Request::create("/holidays/1", 'PUT', [
			'title' => 'Updated Holiday',
			'description' => 'Updated Description',
			'date' => '2024-12-25',
			'location' => 'Los Angeles',
			'participants' => [
				['name' => 'John Smith'],
			]
		]);

		$mockHoliday = Mockery::mock('alias:' . Holiday::class);
		$mockParticipant = Mockery::mock('alias:' . Participant::class);

		$mockHoliday->shouldReceive('with->where->where->first')
			->once()
			->andReturn($mockHoliday);
		$mockHoliday->shouldReceive('with->find')
			->once()
			->andReturn($mockHoliday);
		$mockHoliday->shouldReceive('save')
			->once()
			->andReturn(true);
		$mockHoliday->shouldReceive('participants')
			->once()
			->andReturn($mockParticipant);

		$mockParticipant->shouldReceive('create')->once();

		$mockHoliday->participants = $mockParticipant;

		$holidayService = new HolidayService();

		//Act
		$response = $holidayService->update($request, 1);

		//Assert
		$this->assertEquals(201, $response->status());
		$this->assertEquals('Updated Holiday', $response->getData()->title);
	}

	public function test_destroy()
	{
		//Arrange
		$mockHoliday = Mockery::mock('alias:' . Holiday::class);
		$mockHoliday->shouldReceive('with->where->where->first')
			->once()
			->andReturn((object)['id' => 1, 'title' => 'Holiday 1']);
		$mockHoliday->shouldReceive('destroy')
			->once()
			->andReturn(true);

		$holidayService = new HolidayService();

		//Act
		$response = $holidayService->destroy(1);

		//Assert
		$this->assertEquals(200, $response->status());
	}

	public function test_export_pdf()
	{
		//Arrange
		$mockHoliday = Mockery::mock('alias:' . Holiday::class);
		$mockHoliday->shouldReceive('where->with->get')
			->once()
			->andReturn($mockHoliday);

		$mockView = Mockery::mock('alias:' . View::class);
		$mockView->shouldReceive('render')
			->once();
		$mockView->shouldReceive('make')
			->once()
			->andReturn($mockView);

		$mockPdf = Mockery::mock('alias:' . Pdf::class);
		$mockPdf->shouldReceive('stream')
			->once();
		$mockPdf->shouldReceive('loadHTML')
			->once()
			->andReturn($mockPdf);

		$holidayService = new HolidayService();

		//Act
		$response = $holidayService->exportPdf();

		//Assert
		$this->assertNull($response);
	}

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
