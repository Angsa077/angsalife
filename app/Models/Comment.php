<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'approved',
        'user_id',
        'post_id',
    ];

    protected $appends = ['date_formatted'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getDateFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('Y/m/d h:i a');
    }
}
