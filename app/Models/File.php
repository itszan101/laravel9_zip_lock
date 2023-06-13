<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name', 'password', 'path'];
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class File extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'name',
//         'path',
//         'password',
//         'user_id',
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }
// }
