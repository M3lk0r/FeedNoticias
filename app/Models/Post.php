<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'content', 'scheduled_at', 'published_at', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Verifica se a postagem já foi publicada
    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    // Método para publicar o post
    public function publish()
    {
        $this->status = 'published';
        $this->published_at = Carbon::now();
        $this->save();
    }
}