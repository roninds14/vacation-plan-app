<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('holidays', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->text('description')->nullable();
			$table->date('date');
			$table->string('location')->nullable();
			$table->timestamps();
		});

		Schema::create('participants', function (Blueprint $table) {
			$table->id();
			$table->foreignId('holiday_id')->constrained()->onDelete('cascade');
			$table->string('name');
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('participants');
		Schema::dropIfExists('holidays');
	}
};
