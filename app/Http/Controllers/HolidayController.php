<?php

namespace App\Http\Controllers;

use App\Http\Services\IHolidayService;
use App\Models\Holiday;
use App\Models\Participant;
use Exception;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
	protected $service;

	public function __construct(IHolidayService $service)
	{
		$this->service = $service;
	}

	public function index()
	{
		return $this->service->index();
	}

	public function store(Request $request)
	{
		return $this->service->store($request);
	}

	public function show(string $id)
	{
		return $this->service->show($id);
	}

	public function update(Request $request, string $id)
	{
		return $this->service->update($request, $id);
	}

	public function destroy(string $id)
	{
		return $this->service->destroy($id);
	}

	public function exportPdf() {
		return $this->service->exportPdf();
	}
}
