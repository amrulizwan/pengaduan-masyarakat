<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'response_note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responseNotes()
    {
        return $this->hasMany(ResponseNote::class)->with('admin:id,name');
    }

    public function scopeWithUser($query)
    {
        return $query->with('user:id,name,email');
    }

    public function scopeWithResponseNotes($query)
    {
        return $query->with('responseNotes');
    }
}
