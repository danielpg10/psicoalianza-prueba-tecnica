<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'surname', 
        'identification', 
        'address', 
        'phone',
        'city_id', 
        'boss_id', 
        'is_president'
    ];

    protected $casts = [
        'is_president' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($employee) {
            if ($employee->is_president) {
                $existingPresident = self::where('is_president', true)
                    ->where('id', '!=', $employee->id)
                    ->first();

                if ($existingPresident) {
                    throw new \Exception("Ya existe un presidente registrado: {$existingPresident->full_name}");
                }
                
                $employee->boss_id = null;
            }
        });
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function boss(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'boss_id')
            ->withDefault([
                'name' => 'Sin jefe',
                'surname' => ''
            ]);
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'boss_id');
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class)
            ->withTimestamps()
            ->withPivot('created_at');
    }
}