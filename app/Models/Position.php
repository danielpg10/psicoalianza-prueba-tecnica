<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_unique'];
    
    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            if (self::count() === 0) {
                $positions = [
                    ['name' => 'Presidente', 'is_unique' => true],
                    ['name' => 'Empleado', 'is_unique' => false],
                    ['name' => 'Jefe', 'is_unique' => false]
                ];
                
                foreach ($positions as $position) {
                    self::create($position);
                }
            }
        });
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function isPresidenteOccupied()
    {
        return $this->name === 'Presidente' && $this->employees()->exists();
    }
}