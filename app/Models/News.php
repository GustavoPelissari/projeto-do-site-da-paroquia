<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'image',
        'featured_image',
        'status',
        'featured',
        'user_id',
        'group_id',
        'created_by',
        'scope',
        'published_at',
    ];
    
    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
    
    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
    
    // Relationships
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
    
    // Helpers
    public function isPublished()
    {
        return $this->status === 'published';
    }
    
    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit($this->content, 150);
    }
}
