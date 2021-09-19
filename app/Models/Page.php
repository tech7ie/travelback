<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'lang',
        'meta_title',
        'meta_keywords',
        'meta_descriptions',
        'body'
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
