<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetFile extends Model
{
    use HasFactory;

    protected $table = 'tweet_files';

    protected $fillable = ['tweet_id', 'file'];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
