<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public static $rules = [
        'title' => 'required|unique:posts|min:3',
        'description' => 'required|min:10'
    ];

    protected $fillable = ['title', 'description', 'website_id'];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
