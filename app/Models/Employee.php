<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'surname', 'identification', 'address', 'phone',
        'city_id', 'boss_id', 'is_president'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($employee) {
            if ($employee->is_president) {
                if (self::where('is_president', true)
                    ->where('id', '!=', $employee->id)
                    ->exists()) {
                    throw new \Exception('Solo puede existir un presidente en la organización');
                }
                
                $employee->boss_id = null;
            }
        });
    }

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
        return $this->belongsToMany(Position::class)->withTimestamps();
    }
}