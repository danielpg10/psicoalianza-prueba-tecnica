<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            if (self::count() === 0) {
                $countries = [
                    ['name' => 'Colombia'],
                    ['name' => 'Argentina'],
                    ['name' => 'México'],
                    ['name' => 'Ecuador']
                ];
                
                foreach ($countries as $country) {
                    self::create($country);
                }
            }
        });
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}