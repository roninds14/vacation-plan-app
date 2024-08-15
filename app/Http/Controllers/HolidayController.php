<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
	public function index()
	{
		return "All";
	}

	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'title' => 'required|string|max:255',
			'description' => 'nullable|string',
			'date' => 'required|date',
			'location' => 'nullable|string|max:255',
			'participants' => 'nullable|array',
			'participants.*.name' => 'required|string|max:255',
		]);

		$holiday = Holiday::create($validatedData);

		if (!empty($validatedData['participants'])) {
			foreach ($validatedData['participants'] as $participant) {
				$holiday->participants()->create($participant);
			}
		}

		return response()->json($holiday, 201);
	}

	public function show(string $id)
	{
		return "Id: " . $id;
	}

	public function update(Request $request, string $id)
	{
		return $request;
	}

	public function destroy(Holiday $holiday)
	{
		return $holiday;
	}
}
