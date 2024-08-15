<?php

namespace App\Http\Services;
use Illuminate\Http\Request;

interface IHolidayService
{
	public function index();

	public function store(Request $request);

	public function show(string $id);

	public function update(Request $request, string $id);

	public function destroy(string $id);

	public function exportPdf();
}
