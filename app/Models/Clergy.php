<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clergy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'photo',
        'bio',
        'email',
        'phone',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRoleNameAttribute()
    {
        $roles = [
            'paroco' => 'Pároco',
            'vigario' => 'Vigário Paroquial',
            'padre_colaborador' => 'Padre Colaborador',
            'diacono' => 'Diácono',
        ];

        return $roles[$this->role] ?? $this->role;
    }
}
