<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

	public function up()
	{
		Schema::create('sessions', function (Blueprint $table) {
			$table->string('id', 64)->primary();
			$table->string('payload', 256);
			$table->string('last_activity', 64);
			$table->string('user_id', 64);
			$table->string('ip_address', 64);
			$table->string('user_agent', 64)->nullable();
		});
	}

	public function down()
	{
		Schema::dropIfExists('sessions');
	}
};
