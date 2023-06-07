<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'budget',
        'groups',
    ];

    public function users()
    {

        return $this->hasMany(User::class);
    }

    public function activities()
    {

        return $this->hasMany(Activity::class);
    }

    public function groups()
    {

        return $this->hasMany(Group::class);
    }
}
