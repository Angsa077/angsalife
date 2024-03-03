<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'published',
        'user_id',
        'category_id'
    ];

    protected $appends = ["image_url", "date_formatted", "excerpt"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user', 'post');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image!=""?url("uploads/" . $this->image):"";
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->with('user', 'post')->where('approved', 1);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
    public function getDateFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('F d, Y');
    }
    public function getExcerptAttribute()
    {
        return substr(strip_tags($this->content), 0, 100);
    }
}
