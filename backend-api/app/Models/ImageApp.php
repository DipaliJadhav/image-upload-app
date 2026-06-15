<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ImageApp extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id',
    'label',
    'image_path',
    'status',
    'file_size',
    'mime_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
