<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'name',
        'spv',
    ];

    // Relationship Users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relationship Field
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    // Relationship Activities
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
