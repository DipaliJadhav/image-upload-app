<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ImageApp extends Model
{
    protected $fillable = [
    'user_id',
    'label',
    'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
