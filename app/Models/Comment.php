<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = [ 'correo', 'apodo', 'post_id', 'texto'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class , 'post_id');
        
    }
    
}
