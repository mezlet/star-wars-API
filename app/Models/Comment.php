<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'ip',
        'details',
        'movie_id'
    ];
    protected $table = 'comment';
    protected $dates = [];
    public static $rules = [];
}
