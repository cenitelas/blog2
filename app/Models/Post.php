<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'content', 'image_path'
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function(Post $post){
            $post->deleteImage();
        });
    }

    function user() {
        return $this->belongsTo(User::class);
    }

    function category() {
        return $this->belongsTo(Category::class);
    }

    function likes(){
        return $this->hasMany(Like::class);
    }

    function comments(){
        return $this->hasMany(Comment::class);
    }

    function isLikeBy(User $user){
        return $this->likes()
            ->where('user_id',$user->id)
            ->exists();
    }

    function deleteImage(){
        if(!$this->image_path)
            return;
        unlink(storage_path('app/' . $this->image_path));
    }

}
