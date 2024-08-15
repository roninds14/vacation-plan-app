<?php

namespace App\Http\Services;

use App\Models\Holiday;
use App\Models\Participant;
use Exception;
use Illuminate\Http\Request;

class HolidayService implements IHolidayService
{
	public function index()
	{
		$eagerHoliday = [];
		$holidays[] = Holiday::all();

		foreach ($holidays as $holiday) {
			array_push($eagerHoliday, Holiday::with('participants')->find($holiday));
		}

		return response()->json($eagerHoliday, 200);
	}

	public function store(Request $request)
	{
		$validatedData = $this->validateData($request);

		if (array_key_exists('error', $validatedData)) {
			return response()->json($validatedData, 422);
		}

		$holiday = Holiday::create($validatedData);

		if (!empty($validatedData['participants'])) {
			foreach ($validatedData['participants'] as $participant) {
				$holiday->participants()->create($participant);
			}
		}

		return response()->json(
			Holiday::with('participants')->find($holiday['id']),
			201
		);
	}

	public function show(string $id)
	{
		$holiday = Holiday::with('participants')->find($id);

		return response()->json($holiday, $holiday !== null ? 200 : 204);
	}

	public function update(Request $request, string $id)
	{
		$validatedData = $this->validateData($request);

		if (array_key_exists('error', $validatedData)) {
			return response()->json($validatedData, 422);
		}

		$holiday = Holiday::with('participants')->find($id);

		if ($holiday === null) {
			return response()->json('No Content', 204);
		}

		$holiday->title = $validatedData['title'];
		$holiday->description = $validatedData['description'];
		$holiday->date = $validatedData['date'];
		$holiday->location = $validatedData['location'];

		$holidayUpdateresult = $holiday->save();

		if (!$holidayUpdateresult) {
			return response()->json(
				[
					'error' => 'Could not save data.',
					'data' => $holiday
				],
				400
			);
		}

		foreach ($holiday->participants as $participant) {
			Participant::destroy($participant['id']);
		}

		if ($holidayUpdateresult && !empty($validatedData['participants'])) {
			foreach ($validatedData['participants'] as $participant) {
				$holiday->participants()->create($participant);
			}
		}

		return response()->json(
			Holiday::with('participants')->find($id),
			201
		);
	}

	public function destroy(string $id)
	{
		$holiday['deleted'] = Holiday::with('participants')->find($id);
		$result = Holiday::destroy($id);

		return response()->json(
			$holiday,
			$result ? 200 : 204
		);
	}

	private function validateData(Request $request)
	{
		$validateData = [];

		try {
			$validateData = $request->validate([
				'title' => 'required|string|max:255',
				'description' => 'string',
				'date' => 'required|date',
				'location' => 'string|max:255',
				'participants' => 'nullable|array',
				'participants.*.name' => 'required|string|max:255',
			]);
		} catch (Exception $e) {
			$validateData = [
				'error' => "Validation failed. {$e->getMessage()}",
				'data' => $request->all()
			];
		}

		return $validateData;
	}

	public function exportPdf(){

	}
}
