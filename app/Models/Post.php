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

    private $fillable = ['title', 'description'];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
