<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'date',
		'location',
		'user_id'
	];

	public function participants()
	{
		return $this->hasMany(Participant::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
