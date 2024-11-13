<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'news';

// Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'title', 'author', 'description', 'content', 'url', 'url_image', 'published_at', 'category'
    ];
}
