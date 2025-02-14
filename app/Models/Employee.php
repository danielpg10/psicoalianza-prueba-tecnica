<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'surname', 'identification', 'address', 'phone', 'city_id', 'boss_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function boss()
    {
        return $this->belongsTo(Employee::class, 'boss_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'boss_id');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }
}