<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mass extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'day_of_week',
        'time',
        'location',
        'description',
        'is_active',
    ];
    
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'time' => 'datetime:H:i',
        ];
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function getDayNameAttribute()
    {
        $days = [
            'sunday' => 'Domingo',
            'monday' => 'Segunda-feira',
            'tuesday' => 'Terça-feira',
            'wednesday' => 'Quarta-feira',
            'thursday' => 'Quinta-feira',
            'friday' => 'Sexta-feira',
            'saturday' => 'Sábado',
        ];
        
        return $days[$this->day_of_week] ?? $this->day_of_week;
    }
    
    public function getDayOfWeekName()
    {
        return $this->getDayNameAttribute();
    }
}
