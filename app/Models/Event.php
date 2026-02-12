<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'image',
        'featured_image',
        'status',
        'category',
        'max_participants',
        'requirements',
        'user_id',
        'group_id',
        'created_by',
        // A coluna "scope" não existe na tabela events; removido para evitar erros
    ];
    
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
    
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }
    
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function isUpcoming()
    {
        return $this->start_date > now();
    }
}
